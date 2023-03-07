<?php

class BiomeForest extends BiomeWithGrass
{
	public function __construct($id, $name){ //TODO tree populators
		parent::__construct($id, $name);
		
		$this->setMinMax(63, 81);
	}
}

