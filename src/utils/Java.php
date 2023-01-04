<?php

//TODO remove
class Java_String{

	private $value = "", $count = 0, $hash = 0;

	public function __construct($string = false){
		if($string !== false){
			$this->value = (string) $string;
			$this->count = strlen($this->value);
		}
	}

	public function __toString(){
		return $this->value;
	}

	public function lenght(){
		return $this->count;
	}

	public function isEmpty(){
		return $this->count === 0;
	}

	public function hashCode(){
		$h = $this->hash;
		if($h === 0 and $this->count > 0){
			for($i = 0; $i < $this->count; ++$i){
				$h = (($h << 5) - $h) + ord($this->charAt($i));
				$h = $h & 0xFFFFFFFF;
				$this->hash = $h;
			}
			$this->hash = $h;
		}
		return $h;
	}

	public function charAt($index){
		$index = (int) $index;
		if($index < 0 or $index >= $this->count){
			trigger_error("Undefined offset $index", E_USER_WARNING);
			return false;
		}
		return $this->value[$index];
	}
}