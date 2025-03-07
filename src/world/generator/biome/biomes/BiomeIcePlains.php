<?php

class BiomeIcePlains extends BiomeWithSnow
{
	public function __construct($id, $name){
		parent::__construct($id, $name);
		
		$this->setMinMax(63, 74);
		$this->setTempDown(0.0, 0.5);
	}
}

