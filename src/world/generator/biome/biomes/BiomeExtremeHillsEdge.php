<?php

class BiomeExtremeHillsEdge extends BiomeExtremeHills
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setMinMax(63, 97);
		$this->setTempDown(0.2, 0.3);
	}
}

