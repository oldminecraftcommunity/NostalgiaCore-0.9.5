<?php

class SmallFarmStructure extends Structure{
	public $width = 7;
    public $length = 9;
	public $name = "Small Farm";
	protected $structure = [
		0 => [
			"WWWWWWW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WWWWWWW",
		],
    	1 => [
    		"",
    		" RR RR ",
    		" RR RR ",
    		" RR RR ",
    		" RR RR ",
    		" RR RR ",
    		" RR RR ",
    		" RR RR ",
    		"",
    	],
	];
	
	protected $map = [
		"W" => WOOD,
		"F" => FARMLAND,
		"w" => WATER,
		" " => 0,
		"D" => DIRT
	];

	protected function getFinalStructure(Level $level, $x, $y, $z){
		if(!$level->getBlockWithoutVector($x, $y - 1, $z)->isSolid){
			$structCopy = $this->structure;
			$structCopy[-1] = array_fill(0, $this->length, str_repeat("D", $this->width)); //TODO sand or clay, check for the whole row of water?
			return $structCopy;
		}
		return parent::getFinalStructure($level, $x, $y, $z);
	}
	
	protected function getMappingFor($char){
		if($char === "R"){
			$f = lcg_value();
			
			if($f <= 0.5){
				return [WHEAT_BLOCK, 0];
			}
			if($f <= 0.7){
				return [CARROT_BLOCK, 0];
			}
			if($f <= 0.9){
				return [POTATO_BLOCK, 0];
			}
			return [BEETROOT_BLOCK, 0];
		}
		return parent::getMappingFor($char);
	}
}