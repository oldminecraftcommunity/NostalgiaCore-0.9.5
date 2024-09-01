<?php

abstract class ThreadedLevelGenerator extends Threaded implements NewLevelGenerator{
	public $thread;
	public function __construct($options = []){
		$this->thread = new ChunkGenerationThread($this);
		$this->thread->start();
	}
	
	abstract function getChunkData($x, $z);
	abstract function getBiomeChunkData($x, $z);
	abstract function generateChunkMT($x, $z);
	public function requestChunk($x, $z){
		$this->thread->requested[] = [$x, $z];
	}
	
	public function populateLevel(){}
}

