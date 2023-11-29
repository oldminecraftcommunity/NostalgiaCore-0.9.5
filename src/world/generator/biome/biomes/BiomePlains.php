<?php

class BiomePlains extends BiomeWithGrass{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setMinMax(61, 68);
	}
	
	public function getTree(Random $random){
		return $random->nextInt(10) == 0 ? new SmallTreeObject(SaplingBlock::OAK) : null;
	}
}
