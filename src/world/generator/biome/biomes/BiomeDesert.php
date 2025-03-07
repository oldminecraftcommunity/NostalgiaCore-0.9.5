<?php

class BiomeDesert extends BiomeWithSand
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setMinMax(63, 74);
		$this->setTempDown(2.0, 0.0);
	}
	
	public function createBiomeDecorator(){
		return new DesertBiomeDecorator();
	}
}

