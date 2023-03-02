<?php

class BiomeWithGrass extends Biome
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setTopBlock(GRASS);
		$this->setFillerBlock(STONE);
	}
}

