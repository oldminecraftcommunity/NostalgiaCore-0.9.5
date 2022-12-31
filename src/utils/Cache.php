<?php

class Cache{

	public static $cached = [];

	public static function add($identifier, $blob, $minTTL = 30){
		self::$cached[$identifier] = [$blob, microtime(true) + $minTTL, $minTTL];
	}

	public static function get($identifier){
		if(isset(self::$cached[$identifier])){
			self::$cached[$identifier][1] = microtime(true) + self::$cached[$identifier][2];
			return self::$cached[$identifier][0];
		}

		return false;
	}

	public static function exists($identifier){
		return isset(self::$cached[$identifier]);
	}

	public static function remove($identifier){
		unset(self::$cached[$identifier]);
	}

	public static function cleanup(){
		$time = microtime(true);
		foreach(self::$cached as $index => $data){
			if($data[1] < $time){
				unset(self::$cached[$index]);
			}
		}
	}
}