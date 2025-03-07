<?php

class BiomeExtremeHills extends BiomeWithGrass{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setMinMax(63, 127);
		$this->setTempDown(0.2, 0.3);
	}
}
