<?php

class BiomeOcean extends BiomeWithGrass
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		//TODO pop sugarcane, tallgrass
		$this->setMinMax(46, 68);
		$this->setTempDown(0.5, 0.5);
	}
}

