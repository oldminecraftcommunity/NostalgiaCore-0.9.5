<?php

class BiomeWithGrass extends Biome
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setTopBlocks([
			[GRASS, 0],
			[DIRT, 0],
			[DIRT, 0],
			[DIRT, 0],
			[DIRT, 0],
		]);
		$this->setFillerBlock(STONE);
	}
}

