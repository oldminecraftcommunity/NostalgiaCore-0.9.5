<?php

class BiomeJungle extends BiomeWithGrass
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setMinMax(63, 81);
		$this->setTempDown(0.95, 0.9);
	}
	
	public function getTree(Random $random){
		return new SmallTreeObject(SaplingBlock::JUNGLE);
	}
}

