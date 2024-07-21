<?php

define("ASYNC_CURL_GET", 1);
define("ASYNC_CURL_POST", 2);

class AsyncMultipleQueue extends Thread{

	public $input;
	public $output;
	public $stop;
	public function __construct(){
		$this->input = "";
		$this->output = "";
		$this->stop = false;
		$this->start();
	}

	public function run(){
		while($this->stop === false){
			if(isset($this->input[5])){ //len 6 min
				$rID = Utils::readInt($this->get(4));
				switch(Utils::readShort($this->get(2), false)){
					case ASYNC_CURL_GET:
						$url = $this->get(Utils::readShort($this->get(2), false));
						$timeout = Utils::readShort($this->get(2));
						$headers = $this->get(Utils::readShort($this->get(2), false));
						$res = (string) Utils::curl_get($url, $timeout, $headers);
						//$this->lock();
						$this->output .= Utils::writeInt($rID) . Utils::writeShort(ASYNC_CURL_GET) . Utils::writeInt(strlen($res)) . $res;
						//$this->unlock();
						break;
					case ASYNC_CURL_POST:
						$url = $this->get(Utils::readShort($this->get(2), false));
						$timeout = Utils::readShort($this->get(2));
						$cnt = Utils::readShort($this->get(2), false);
						$d = [];
						for($c = 0; $c < $cnt; ++$c){
							$key = $this->get(Utils::readShort($this->get(2), false));
							$d[$key] = $this->get(Utils::readInt($this->get(4), false));
						}
						$res = (string) Utils::curl_post($url, $d, $timeout);
						//$this->lock();
						$this->output .= Utils::writeInt($rID) . Utils::writeShort(ASYNC_CURL_POST) . Utils::writeInt(strlen($res)) . $res;
						//$this->unlock();
						break;
				}
			}
			usleep(10000);
		}
	}

	private function get($len){
		$str = "";
		if($len <= 0){
			return $len;
		}
		$offset = 0;
		while(!isset($str[$len - 1])){
			if(isset($this->input[$offset])){
				$str .= $this->input[$offset];
				++$offset;
			}
		}
		$this->input = (string) substr($this->input, $offset);
		return $str;
	}
}

class Async extends Thread{

	public function __construct($method, $params = []){
		$this->method = $method;
		$this->params = $params;
		$this->result = null;
		$this->joined = false;
	}

	public static function call($method, $params = []){
		$thread = new Async($method, $params);
		if($thread->start()){
			return $thread;
		}
	}

	public function run(){
		if(($this->result = call_user_func_array($this->method, $this->params))){
			//return true;
		}else{
			//return false;
		}
	}

	public function __toString(){
		if(!$this->joined){
			$this->joined = true;
			$this->join();
		}

		return $this->result;
	}
}

/*class StackableArray extends Stackable{
	public function __construct(){
		foreach(func_get_args() as $n => $value){
			if(is_array($value)){
				$this->{$n} = new StackableArray();
				call_user_func_array(array($this->{$n}, "__construct"), $value);
			}else{
				$this->{$n} = $value;
			}
		}
	}
	
	public function __destruct(){}
	
	public function run(){}
}*/
