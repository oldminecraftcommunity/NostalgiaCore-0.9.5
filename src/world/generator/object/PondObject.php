<?php

class PondObject{

	public $type;
	private $random;

	public function __construct(Random $random, Block $type){
		$this->type = $type;
		$this->random = $random;
	}

	public function canPlaceObject(Level $level, Vector3 $pos){
	}

	public function placeObject(Level $level, Vector3 $pos){
	}
}