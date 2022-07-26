<?php

class Container{

	private $payload = "", $whitelist = false, $blacklist = false;

	public function __construct($payload = "", $whitelist = false, $blacklist = false){
		$this->payload = $payload;
		if(is_array($whitelist)){
			$this->whitelist = $whitelist;
		}
		if(is_array($blacklist)){
			$this->blacklist = $blacklist;
		}
	}

	public function get(){
		return $this->payload;
	}

	public function check($target){
		$w = true;
		$b = false;
		if($this->whitelist !== false){
			$w = false;
			if(in_array($target, $this->whitelist, true)){
				$w = true;
			}
		}else{
			$w = true;
		}
		if($this->blacklist !== false){
			$b = false;
			if(in_array($target, $this->blacklist, true)){
				$b = true;
			}
		}else{
			$b = false;
		}
		if($w === false or $b === true){
			return false;
		}
		return true;
	}


	public function __toString(){
		return $this->payload;
	}
}