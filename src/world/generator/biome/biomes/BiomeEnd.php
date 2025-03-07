<?php

class BiomeEnd extends Biome
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setTempDown(0.0, 0.0);
	}
}

