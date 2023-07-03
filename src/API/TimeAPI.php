<?php

class TimeAPI{

	public static $phases = [
		"day" => 0,
		"sunset" => 9500,
		"night" => 10900,
		"sunrise" => 17800,
	];
	private $server;

	function __construct(){
		$this->server = ServerAPI::request();
	}

	public function init(){
		$this->server->api->console->register("time", "<check|set|add> [time]", [$this, "commandHandler"]);
	}

	public function commandHandler($cmd, $args, $issuer, $alias){
		$output = "";
		switch($cmd){
			case "time":
				$level = false;
				if($issuer instanceof Player){
					$level = $issuer->level;
				}else{
					$level = $this->server->api->level->getDefault();
				}
				$p = strtolower(array_shift($args));
				switch($p){
					case "check":
						if(substr($args[0] ?? "", 0, 2) === "w:"){
							$levelName = preg_replace("/w:/", "", $args[0]);
							$level = $this->server->api->level->get($levelName);
							if($level instanceof Level){
								$world = " in world \"$levelName\"";
							}else{
								$output .= "World \"$levelName\" doesn't exist or loaded!";
								break;
							}
						}else $world = " in world \"" . $level->getName() . "\"";
						$output .= "Time" . $world . ": " . $this->getDate($level) . ", " . $this->getPhase($level) . " (" . $this->get(true, $level) . " ticks)\n";
						break;
					case "add":
						if(substr($args[1] ?? "", 0, 2) === "w:"){
							$levelName = preg_replace("/w:/", "", $args[1]);
							$level = $this->server->api->level->get($levelName);
							if($level instanceof Level){
								$world = " to the time of world \"$levelName\"";
							}else{
								$output .= "World \"$levelName\" doesn't exist or loaded!";
								break;
							}
						}else $world = " to the time of world \"" . $level->getName() . "\"";

						$addTime = array_shift($args);
						if(!is_numeric($addTime)){
							$output .= "Time must be an integer!";
							break;
						}
						$addTime = (int) $addTime;
						$this->add($addTime, $level);
						$output .= "Added $addTime ticks" . $world . "\n";
						break;
					case "set":
						if(isset($args[1]) and substr($args[1], 0, 2) === "w:"){
							$levelName = preg_replace("/w:/", "", $args[1]);
							$level = $this->server->api->level->get($levelName);
							if($level instanceof Level){
								$world = " in world \"$levelName\"";
							}else{
								$output .= "World \"$levelName\" doesn't exist or loaded!";
								break;
							}
						}else $world = " in world \"" . $level->getName() . "\"";

						$setTime = array_shift($args);
						if(is_numeric($setTime)){
							$setTime = (int) $setTime;
						}elseif($setTime == 'sunrise' or $setTime == 'day' or $setTime == 'sunset' or $setTime == 'night')
							;
						else{
							$output .= "Wrong time!";
							break;
						}
						$this->set($setTime, $level);
						$output .= "Set the time to " . $setTime . $world . "\n";
						break;
					case "sunrise":
					case "day":
					case "sunset":
					case "night":
						if(count($args) > 1 && substr($args[1], 0, 2) === "w:"){
							$levelName = preg_replace("/w:/", "", $args[1]);
							$level = $this->server->api->level->get($levelName);
							if($level instanceof Level){
								$world = " in world \"$levelName\"";
							}else{
								$output .= "World \"$levelName\" doesn't exist or loaded!";
								break;
							}
						}else $world = " in world \"" . $level->getName() . "\"";

						$this->set($p, $level);
						$output .= "Set the time to " . $p . $world . "\n";
						break;
					default:
						$output .= "Usage: /time <check|set|add> [time] [w:world]\n";
						break;
				}
				break;
		}
		return $output;
	}

	public function getDate($time = false){
		$time = !is_integer($time) ? $this->get(false, $time) : $time;
		return str_pad(strval((floor($time / 800) + 6) % 24), 2, "0", STR_PAD_LEFT) . ":" . str_pad(strval(floor(($time % 800) / 13.33)), 2, "0", STR_PAD_LEFT);
	}

	public function get($raw = false, $level = false){
		if(!($level instanceof Level)){
			$level = $this->server->api->level->getDefault();
		}
		return $raw === true ? $level->getTime() : abs($level->getTime()) % 19200;
	}

	public function getPhase($time = false){
		$time = !is_integer($time) ? $this->get(false, $time) : $time;
		if($time < TimeAPI::$phases["sunset"]){
			$time = "day";
		}elseif($time < TimeAPI::$phases["night"]){
			$time = "sunset";
		}elseif($time < TimeAPI::$phases["sunrise"]){
			$time = "night";
		}else{
			$time = "sunrise";
		}
		return $time;
	}

	public function add($time, $level = false){
		if(!($level instanceof Level)){
			$level = $this->server->api->level->getDefault();
		}
		$level->setTime($level->getTime() + (int) $time);
	}

	public function set($time, $level = false){
		if(!($level instanceof Level)){
			$level = $this->server->api->level->getDefault();
		}
		if(is_string($time) and isset(TimeAPI::$phases[$time])){
			$level->setTime(TimeAPI::$phases[$time]);
		}else{
			$level->setTime((int) $time);
		}
		return $level->getTime();
	}

	public function night(){
		return $this->set("night");
	}

	public function day(){
		return $this->set("day");
	}

	public function sunrise(){
		return $this->set("sunrise");
	}

	public function sunset(){
		return $this->set("sunset");
	}


}
