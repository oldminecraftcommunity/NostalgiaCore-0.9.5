<?php

/*
Implementation of the Source RCON Protocol to allow remote console commands
Source: https://developer.valvesoftware.com/wiki/Source_RCON_Protocol
*/

class RCON{
	/**
	 * @var Array[RCONInstance]
	 */
	private $workers;
	
	private $socket, $password, $threads, $clientsPerThread;

	public function __construct($password, $port = 19132, $interface = "0.0.0.0", $threads = 1, $clientsPerThread = 50){
		$this->workers = [];
		$this->password = (string) $password;
		console("[INFO] Starting remote control listener");
		if($this->password === ""){
			console("[ERROR] RCON can't be started: Empty password");
			return;
		}
		$this->threads = (int) max(1, $threads);
		$this->clientsPerThread = (int) max(1, $clientsPerThread);
		$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($this->socket === false or !socket_bind($this->socket, $interface, (int) $port) or !socket_listen($this->socket)){
			console("[ERROR] RCON can't be started: " . socket_strerror(socket_last_error()));
			return;
		}
		@socket_set_block($this->socket);
		for($n = 0; $n < $this->threads; ++$n){
			$this->workers[$n] = new RCONInstance($this->socket, $this->password, $this->clientsPerThread);
		}
		@socket_getsockname($this->socket, $addr, $port);
		console("[INFO] RCON running on $addr:$port");
		ServerAPI::request()->schedule(2, [$this, "check"], [], true);
	}

	public function stop(){
		for($n = 0; $n < $this->threads; ++$n){
			$this->workers[$n]->close();
			$this->workers[$n]->join();
			usleep(50000);
			$this->workers[$n]->kill();
		}
		@socket_close($this->socket);
		$this->threads = 0;
	}

	public function check(){
		foreach($this->workers as $w){
			$w->synchronized(function($rcon, $worker){
				if($worker->isTerminated()){
					$worker = new RCONInstance($rcon->socket, $rcon->password, $rcon->clientsPerThread);
				}//elseif($worker->isWaiting()){
				$worker->response = ServerAPI::request()->api->console->run($worker->cmd, "rcon");
				$worker->cmd = "";
				$worker->notify();
				//}
			}, $this, $w);
		}
	}

}

class RCONInstance extends Thread{

	public $stop;
	public $cmd;
	public $response;
	private $socket;
	private $password;
	private $maxClients;
	public function __construct($socket, $password, $maxClients = 50){
		$this->stop = false;
		$this->cmd = "";
		$this->response = "";
		$this->socket = $socket;
		$this->password = $password;
		$this->maxClients = (int) $maxClients;
		$this->start();
	}
	
	public function close(){
		$this->stop = true;
	}

	public function run(){
		$clients = [];
		$authenticated = [];
		$timeouts = [];
		$nextClientId = 0;
		while($this->stop !== true){
			$r = $clients;
			$r["main"] = $this->socket; //this is ugly, but we need to be able to mass-select()
			$w = null;
			$e = null;
			$disconnect = [];
			if(socket_select($r, $w, $e, 5, 0) > 0){
				foreach($r as $id => $sock){
					if($sock === $this->socket){
						if(($client = socket_accept($this->socket)) !== false){
							if(count($clients) >= $this->maxClients){
								@socket_close($client);
							}else{
								socket_set_nonblock($client);
								socket_set_option($client, SOL_SOCKET, SO_KEEPALIVE, 1);
								
								$id = $nextClientId++;
								$clients[$id] = $client;
								$authenticated[$id] = false;
								$timeouts[$id] = microtime(true) + 5;
							}
						}
					}else{
						$p = $this->readPacket($sock, $size, $requestID, $packetType, $payload);
						if($p === false){
							$disconnect[$id] = $sock;
							continue;
						}
						
						switch($packetType){
							case 3: //Login
								if($authenticated[$id]){
									$disconnect[$id] = $sock;
									break;
								}
								socket_getpeername($sock, $addr, $port);
								if($payload === $this->password){
									console("Successful Rcon connection from: /$addr:$port");
									$this->writePacket($sock, $requestID, 2, "");
									$authenticated[$id] = true;
								}else{
									$disconnect[$id] = $sock;
									$this->writePacket($sock, -1, 2, "");
									$this->logger->info("Unsuccessful connection from: /$addr:$port (wrong password)");
								}
								break;
							case 2: //Command
								if(!$authenticated[$id]){
									$disconnect[$id] = $sock;
									break;
								}
								if($payload !== ""){
									$this->synchronized(function($payload){
										$this->cmd = ltrim($payload);
										$this->wait();
									}, $payload);
									if($this->writePacket($sock, $requestID, 0, str_replace("\n", "\r\n", trim($this->response))) === false){
										$disconnect[$id] = $sock;
									}
									$this->response = "";
									$this->cmd = "";
								}
								break;
						}
					}
				}
			}
			
			foreach($authenticated as $id => $status){
				if(!isset($disconnect[$id]) and !$authenticated[$id] and $timeouts[$id] < microtime(true)){ //Timeout
					$disconnect[$id] = $clients[$id];
				}
			}
			
			foreach($disconnect as $id => $client){
				$this->disconnectClient($client);
				unset($clients[$id], $authenticated[$id], $timeouts[$id]);
			}
			
			
		}
		foreach($clients as $client){
			$this->disconnectClient($client);
		}
		unset($this->socket, $this->cmd, $this->response, $this->stop);
		exit(0);
	}
	
	private function disconnectClient($client){
		socket_getpeername($client, $ip, $port);
		@socket_set_option($client, SOL_SOCKET, SO_LINGER, ["l_onoff" => 1, "l_linger" => 1]);
		@socket_shutdown($client, 2);
		@socket_set_block($client);
		@socket_read($client, 1);
		@socket_close($client);
		console("Disconnected client: /$ip:$port");
	}
	
	private function readPacket($client, &$size, &$requestID, &$packetType, &$payload){
		@socket_set_nonblock($client);
		$d = @socket_read($client, 4);
		if($this->stop){
			return false;
		}elseif($d === false){
			return null;
		}elseif($d === "" or strlen($d) < 4){
			return false;
		}
		$size = Utils::readLInt($d);
		if($size < 0 or $size > 65535){
			return false;
		}
		$requestID = Utils::readLInt(socket_read($client, 4));
		$packetType = Utils::readLInt(socket_read($client, 4));
		$payload = rtrim(socket_read($client, $size + 2)); //Strip two null bytes
		return true;
	}

	private function writePacket($client, $requestID, $packetType, $payload){
		$pk = Utils::writeLInt((int) $requestID)
			. Utils::writeLInt((int) $packetType)
			. $payload
			. "\x00\x00"; //Terminate payload and packet
		return @socket_write($client, Utils::writeLInt(strlen($pk)) . $pk);
	}
}
