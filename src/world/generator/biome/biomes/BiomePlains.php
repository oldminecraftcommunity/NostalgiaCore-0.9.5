<?php

class BiomePlains extends BiomeWithGrass{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		$this->setMinMax(61, 68);
	}
}
