<?php

class BiomeRiver extends BiomeWithGrass{
	
	public function __construct($id, $name){
		parent::__construct($id, $name);
		
		/*$sugarcane = new Sugarcane();
		$sugarcane->setBaseAmount(6);
		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(5);
		
		$this->addPopulator($sugarcane);
		$this->addPopulator($tallGrass);
		*/
		$this->setMinMax(58, 62);
	}
}
