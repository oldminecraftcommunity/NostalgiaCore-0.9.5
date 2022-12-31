<?php

class QueryAPI{

	public static $NOT_FOUND_VALUE;
	private $queryData;
	private $server;

	public function __construct(){
		$this->server = ServerAPI::request();
		QueryAPI::$NOT_FOUND_VALUE = new NFV();
		$this->updateQueryData("splitnum", chr(128));
		$this->updateQueryData("hostname", $this->server->name);
		$this->updateQueryData("gametype", ($this->server->gamemode & 0x01) === 0 ? "SMP" : "CMP");
		$this->updateQueryData("game_id", "MINECRAFTPE");
		$this->updateQueryData("version", CURRENT_MINECRAFT_VERSION);
		$this->updateQueryData("server_engine", "NostalgiaCore " . MAJOR_VERSION);
		$this->addToQuery("plugins");
		$this->addToQuery("map");
		$this->addToQuery("numplayers");
		$this->updateQueryData("maxplayers", $this->server->maxClients);
		$this->updateQueryData("whitelist", $this->server->api->getProperty("white-list") === true ? "on" : "off");
		$this->updateQueryData("hostport", $this->server->api->getProperty("server-port"));
		$this->addToQuery("tps");
	}

	public function updateQueryData($name, $value){
		$this->queryData[$name] = $value;
	}

	public function addToQuery($name){
		$this->updateQueryData($name, QueryAPI::$NOT_FOUND_VALUE);
	}

	public function getQueryData(){
		return $this->queryData;
	}
}

class NFV{

}