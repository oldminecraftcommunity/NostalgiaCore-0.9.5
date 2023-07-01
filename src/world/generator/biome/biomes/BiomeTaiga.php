<?php

class BiomeTaiga extends BiomeWithSnow
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		
		$this->setMinMax(63, 81);
		$this->setTopBlocks([
			[GRASS, 0],
			[DIRT, 0],
			[DIRT, 0],
			[DIRT, 0],
		]);
	}
}

