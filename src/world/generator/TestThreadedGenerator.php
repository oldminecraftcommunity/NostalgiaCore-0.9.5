<?php

class TestThreadedGenerator extends ThreadedLevelGenerator
{
	public $level, $random;
	
	public $chunkData = [];
	
	public function __construct(array $options = []){
		parent::__construct($options);
	}
	
	public function init(Level $level, Random $random){
		//$this->level = $level; illegal
		//$this->random = $random;
	}

	public function getSpawn(){
		return new Vector3(128, $this->floorLevel, 128);
	}

	public function getChunkData($x, $z){
		return $this->synchronized(function () use ($x, $z){
			return $this->chunkData["$x $z"];
		});
	}
	
	public function setChunkData($x, $z, $chunk){
		$this->synchronized(function() use ($x, $z, $chunk){
			$this->chunkData["$x $z"] = $chunk;
		});
	}
	
	public function getBiomeChunkData($x, $z){
		return str_repeat("\00", 256); //TODO
	}
	
	//only this method should be executed in thread. chunk population is done in main
	public function generateChunkMT($chunkX, $chunkZ){
		console("Generating $chunkX $chunkZ: ".is_object($this->level).".");
		$chunk = [];
		
		for($y = 7; $y >= 0; --$y){
			$mchunk = "";
			for($z = 0; $z < 16; ++$z){
				for($x = 0; $x < 16; ++$x){
					$blocks = "";
					for($i = 0; $i < 16; ++$i) $blocks .= chr(mt_rand(0, 1));
					$mchunk .= $blocks;
					$mchunk .= "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"; //meta
					$mchunk .= "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"; //light/skylight
					$mchunk .= "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"; //skylight/light
				}
				
			}
			console(strlen($mchunk));
			$chunk[$y] = $mchunk;
		}
		usleep(1000000/10); //sleep 0.1 sec
		return $chunk;
	}
	
	public function generateChunk($chunkX, $chunkZ){
		$this->requestChunk($chunkX, $chunkZ);
	}
	
	public function populateChunk($chunkX, $chunkZ){
		console("Populating $chunkX $chunkZ: ".is_object($this->level));
	}
	public function getSettings(){
		return [];
	}

}

