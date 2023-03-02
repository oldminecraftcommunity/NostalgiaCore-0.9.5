<?php

class SmallFarmStructure{
    public static $width = 7;
	public static $lenght = 9;
	public static $tmpStructure;
    public static $structure = [
		-1 => [
			//add sand, clay if here isn't air
		],
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
		]
	];

	public static function generateCrops(){
		self::$tmpStructure = self::$structure;
		$f = Utils::randomFloat();
		if($f <= 0.5){
			self::$tmpStructure[1] = [
				"",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				"",
			];
		}
		elseif($f <= 0.7){
			self::$tmpStructure[1] = [
				"",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				"",
			];
		}
		elseif($f <= 0.9){
			self::$tmpStructure[1] = [
				"",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				"",
			];
		}
		else{
			self::$tmpStructure[1] = [
				"",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				"",
			];
		}
	}

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
		self::generateCrops();

		$offsetX = 0;
		$offsetZ = 0;
		foreach(self::$tmpStructure as $layerCount => $layer){
			foreach($layer as $line){
				$line = rtrim($line); //remove useless spaces(only from right)
				foreach(str_split($line) as $char){
                    $vector = new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z + $offsetZ);
					switch($char){
						case "W":
							$level->setBlockRaw($vector, new WoodBlock());
							break;
						case "F":
							$level->setBlockRaw($vector, new FarmlandBlock());
							break;
						case "w":
							$level->setBlockRaw($vector, new WaterBlock());
							break;
						
						case "H":
							$level->setBlockRaw($vector, new WheatBlock());
							break;
						case "C":
							$level->setBlockRaw($vector, new CarrotBlock());
							break;
						case "P":
							$level->setBlockRaw($vector, new PotatoBlock());
							break;
						case "B":
							$level->setBlockRaw($vector, new BeetrootBlock());
							break;
						case " ":
							$block = $level->getBlock($vector)->getID();
							if($block === AIR){
								break;
							}
							$level->setBlockRaw($vector, new AirBlock());
							break;
					}
					++$offsetX;
				}
				++$offsetZ;
				$offsetX = 0;
			}
			$offsetZ = 0;
		}
	}
}