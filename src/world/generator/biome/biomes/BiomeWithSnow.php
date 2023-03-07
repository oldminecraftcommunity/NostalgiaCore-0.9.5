<?php

class BiomeWithSnow extends Biome
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setTopBlocks([
			[SNOW_LAYER, 0],
			[GRASS, 0],
			[DIRT, 0],
			[DIRT, 0],
			[DIRT, 0],
		]);
		$this->setFillerBlock(STONE);
	}
}

