<?php

class PondObject{

	public $type;
	private $random;

	public function __construct(Random $random, Block $type){
		$this->type = $type;
		$this->random = $random;
	}

	public function canPlaceObject(Level $level, Vector3 $pos){
		//todo checking
		return false;
	}

	public function placeObject(Level $level, Vector3 $pos){
		$level->setBlockRaw($pos, new WaterBlock());
	}
}