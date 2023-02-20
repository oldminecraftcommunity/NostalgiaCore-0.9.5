<?php

class ChatAPI{

	private $server;

	function __construct(){
		$this->server = ServerAPI::request();
	}

	public function init(){
		$this->server->api->console->register("tell", "<player> <private message ...>", [$this, "commandHandler"]);
		$this->server->api->console->register("me", "<action ...>", [$this, "commandHandler"]);
		$this->server->api->console->register("say", "<message ...>", [$this, "commandHandler"]);
		$this->server->api->console->cmdWhitelist("tell");
		$this->server->api->console->cmdWhitelist("me");
		$this->server->api->console->alias("msg", "tell");
	}

	/**
	 * @param string $cmd
	 * @param array $params
	 * @param string $issuer
	 * @param string $alias
	 *
	 * @return string
	 */
	public function commandHandler($cmd, $params, $issuer, $alias){
		$output = "";
		switch($cmd){
			case "say":
				$s = implode(" ", $params);
				if(trim($s) == ""){
					$output .= "Usage: /say <message>\n";
					break;
				}
				$sender = ($issuer instanceof Player) ? "Server" : ucfirst($issuer);
				$this->server->api->chat->broadcast("[$sender] " . $s);
				break;
			case "me":
				$s = implode(" ", $params);
				if(trim($s) == ""){
					$output .= "Usage: /me <message>\n";
					break;
				}
				if(!($issuer instanceof Player)){
					if($issuer === "rcon"){
						$sender = "Rcon";
					}else{
						$sender = ucfirst($issuer);
					}
				}else{
					$sender = $issuer->username;
				}
				$this->broadcast("* $sender " . implode(" ", $params));
				break;
			case "tell":
				if(!isset($params[0]) or !isset($params[1])){
					$output .= "Usage: /$cmd <player> <message>\n";
					break;
				}
				if(!($issuer instanceof Player)){
					$sender = ucfirst($issuer);
				}else{
					$sender = $issuer->username;
				}
				$n = array_shift($params);
				$target = $this->server->api->player->get($n);
				if($target instanceof Player){
					$target = $target->username;
				}else{
					$target = strtolower($n);
					if($target === "server" or $target === "console" or $target === "rcon"){
						$target = "Console";
					}else{
						return "The player is offline.";
					}
				}
				if(strtolower($target) === strtolower($issuer)){
					return "You can't send message to yourself.";
				}
				$mes = implode(" ", $params);
				$output .= "You're whispering to " . $target . ": " . $mes . "\n";
				if($target !== "Console" and $target !== "Rcon"){
					$this->sendTo(false, $sender . " whispers to you: " . $mes, $target);
				}
				if($target === "Console" or $sender === "Console"){
					console("[INFO] " . $sender . " whispers to " . $target . ": " . $mes);
				}
				break;
		}
		return $output;
	}

	/**
	 * @param string $message
	 */
	public function broadcast($message){
		$this->send(false, $message);
		$this->server->send2Discord($message);
	}

	/**
	 * @param mixed $owner Can be either Player object or string username. Boolean false for broadcast.
	 * @param string $text
	 * @param $whitelist
	 * @param $blacklist
	 */
	public function send($owner, $text, $whitelist = false, $blacklist = false){
		$message = [
			"player" => $owner,
			"message" => $text,
		];
		if($owner !== false){
			if($owner instanceof Player){
				if($whitelist === false){
					console("[INFO] <" . $owner->username . "> " . $text);
				}
			}else{
				if($whitelist === false){
					console("[INFO] <" . $owner . "> " . $text);
				}
			}
		}else{
			if($whitelist === false){
				console("[INFO] $text");
			}
			$message["player"] = "";
		}
		$container = new Container($message, $whitelist, $blacklist);
		$this->server->handle("server.chat", $container);
	}

	/**
	 * @param string $owner
	 * @param string $text
	 * @param mixed $player Can be either Player object or string username. Boolean false for broadcast.
	 */
	public function sendTo($owner, $text, $player){
		$this->send($owner, $text, [$player]);
	}
}
