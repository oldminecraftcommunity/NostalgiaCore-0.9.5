<?php

class BiomeExtremeHillsEdge extends BiomeExtremeHills
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setMinMax(63, 97);
	}
}

