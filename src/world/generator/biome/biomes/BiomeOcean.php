<?php

class BiomeOcean extends BiomeWithGrass
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		//TODO pop sugarcane, tallgrass
		$this->setMinMax(46, 68);
	}
}

