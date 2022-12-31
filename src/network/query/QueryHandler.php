<?php

/*
 Implementation of the UT3 Query Protocol (GameSpot)
 Source: http://wiki.unrealadmin.org/UT3_query_protocol
*/

class QueryHandler{

	private $socket, $server, $lastToken, $token, $longData, $timeout;

	public function __construct(){
		console("[INFO] Starting GS4 status listener");
		$this->server = ServerAPI::request();
		$addr = ($ip = $this->server->api->getProperty("server-ip")) != "" ? $ip : "0.0.0.0";
		$port = $this->server->api->getProperty("server-port");
		console("[INFO] Setting query port to $port");
		/*
		The Query protocol is built on top of the existing Minecraft PE UDP network stack.
		Because the 0xFE packet does not exist in the MCPE protocol,
		we can identify	Query packets and remove them from the packet queue.
		
		Then, the Query class handles itself sending the packets in raw form, because
		packets can conflict with the MCPE ones.
		*/

		$this->server->schedule(20 * 30, [$this, "regenerateToken"], [], true);
		$this->regenerateToken();
		$this->lastToken = $this->token;
		$this->regenerateInfo();
		console("[INFO] Query running on $addr:$port");
	}

	public function regenerateToken(){
		$this->lastToken = $this->token;
		$this->token = Utils::readInt("\x00" . Utils::getRandomBytes(3, false));
	}

	public function regenerateInfo(){
		$str = "";
		$plist = "NostalgiaCore " . MAJOR_VERSION;
		if($this->server->extraprops->get("query-plugins") == true){
			$pl = $this->server->api->plugin->getList();
			if(count($pl) > 0){
				$plist .= ":";
				foreach($pl as $p){
					$plist .= " " . str_replace([";", ":", " "], ["", "", "_"], $p["name"]) . " " . str_replace([";", ":", " "], ["", "", "_"], $p["version"]) . ";";
				}
				$plist = substr($plist, 0, -1);
			}
		}
		$this->server->api->queryAPI->updateQueryData("plugins", $plist);
		$this->server->api->queryAPI->updateQueryData("map", $this->server->api->level->getDefault()->getName());
		$this->server->api->queryAPI->updateQueryData("numplayers", count($this->server->clients));
		$this->server->api->queryAPI->updateQueryData("tps", $this->server->debugInfo()["tps"]);
		$this->server->api->dhandle("query.update", null);
		$KVdata = $this->server->api->queryAPI->getQueryData();

		foreach($KVdata as $key => $value){
			$str .= $key . "\x00" . $value . "\x00";
		}
		$str .= "\x00\x01player_\x00\x00";
		foreach($this->server->clients as $player){
			if($player->username != ""){
				$str .= $player->username . "\x00";
			}
		}
		$str .= "\x00";
		$this->longData = $str;
		$this->timeout = microtime(true) + 5;
	}

	public function handle(QueryPacket $packet){
		$packet->decode();
		switch($packet->packetType){
			case QueryPacket::HANDSHAKE: //Handshake
				$pk = new QueryPacket;
				$pk->ip = $packet->ip;
				$pk->port = $packet->port;
				$pk->packetType = QueryPacket::HANDSHAKE;
				$pk->sessionID = $packet->sessionID;
				$pk->payload = $this->token . "\x00";
				$pk->encode();
				$this->server->send($pk);
				break;
			case QueryPacket::STATISTICS: //Stat
				$token = Utils::readInt(substr($packet->payload, 0, 4));
				if($token !== $this->token and $token !== $this->lastToken){
					break;
				}
				$pk = new QueryPacket;
				$pk->ip = $packet->ip;
				$pk->port = $packet->port;
				$pk->packetType = QueryPacket::STATISTICS;
				$pk->sessionID = $packet->sessionID;
				if(strlen($packet->payload) === 8){
					if($this->timeout < microtime(true)){
						$this->regenerateInfo();
					}
					$pk->payload = $this->longData;
				}else{
					$pk->payload = $this->server->name . "\x00" . (($this->server->gamemode & 0x01) === 0 ? "SMP" : "CMP") . "\x00" . $this->server->api->level->getDefault()->getName() . "\x00" . count($this->server->clients) . "\x00" . $this->server->maxClients . "\x00" . Utils::writeLShort($this->server->api->getProperty("server-port")) . $this->server->api->getProperty("server-ip", "0.0.0.0") . "\x00";
				}
				$pk->encode();
				$this->server->send($pk);
				break;
		}
	}

}
