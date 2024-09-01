<?php

class ChunkGenerationThread extends Thread{
	
	public $requested = [];
	public $finished = [];
	
	public $gen;
	
	public function __construct(ThreadedLevelGenerator $gen){
		$this->gen = $gen;
	}
	public function run(){
		cont:
		if(count($this->requested) > 0){
			$chunks = $this->synchronized(function(){
				$chunks = [];
				foreach($this->requested as $k => $c){
					$x = $c[0];
					$z = $c[1];
					$chunks[] = [$x, $z];
					unset($this->requested[$k]);
				}
				
				return $chunks;
			});
			
			console("new cycle start ".count($chunks));
			foreach($chunks as $c){
				$chunk = $this->gen->generateChunkMT($c[0], $c[1]);
				$x = $c[0];
				$z = $c[1]; 
				$this->synchronized(function() use ($chunk, $x, $z){
					$this->finished[] = [$x, $z, $chunk];
					console("generation done ".count($this->finished));
				});
			}
		}
		goto cont;
		
	}
}

