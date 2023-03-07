<?php

class BiomeWithSand extends Biome
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setMinMax(63, 81);
		$this->setTopBlocks([
			[SAND, 0],
			[SAND, 0],
			[SAND, 0],
			[SAND, 0],
			[SANDSTONE, 0],
			[SANDSTONE, 0],
			[SANDSTONE, 0],
			[SANDSTONE, 0],
		]);
		$this->setFillerBlock(STONE);
	}
}

