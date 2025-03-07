<?php

class BiomeHell extends Biome
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setTempDown(2.0, 0.0);
	}
}

