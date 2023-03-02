<?php

class SmallHouseStructure{
    public static $width = 5;
	public static $lenght = 5;
	public static $tmpStructure;
    public static $structure = [
		0 => [
			"CCCCC",
			"CCCCC",
			"CCCCC",
			"CCCCC",
			"CCCCC",
		],
		1 => [
			"CP PC",
			"P   P",
			"P   P",
			"P L P",
			"CPPPC",
		],
		2 => [
			"CP PC",
			"P   P",
			"G   G",
			"P L P",
			"CPPPC",
		],
		3 => [
			"CPPPC",
			"P   P",
			"P   P",
			"P L P",
			"CPPPC",
		],
		4 => [
			"WWWWW",
			"WPPPW",
			"WPPPW",
			"WPPPW",
			"WWWWW",
		]
	];

	public static function generateFence(){
		self::$tmpStructure = self::$structure;
		if(Utils::chance(50)){
			self::$tmpStructure[4] = [
				"WWWWW",
				"WPPPW",
				"WPPPW",
				"WPLPW",
				"WWWWW",
			];
			self::$tmpStructure[5] = [
				"FFFFF",
				"F   F",
				"F   F",
				"F   F",
				"FFFFF",
			];
		}
	}

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
		self::generateFence();

		$offsetX = 0;
		$offsetZ = 0;
		foreach(self::$tmpStructure as $layerCount => $layer){
			foreach($layer as $line){
				$line = rtrim($line); //remove useless spaces(only from right)
				foreach(str_split($line) as $char){
                    $vector = new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z + $offsetZ);
					switch($char){
						case "C":
							$level->setBlockRaw($vector, new CobbleStoneBlock());
							break;
						case "P":
							$level->setBlockRaw($vector, new PlanksBlock());
							break;
						case "W":
							$level->setBlockRaw($vector, new WoodBlock());
							break;
						case "D":
							$level->setBlockRaw($vector, new DirtBlock());
							break;
						case "G":
							$level->setBlockRaw($vector, new GlassPaneBlock());
							break;
						case "L":
							$level->setBlockRaw($vector, new LadderBlock(2));
							break;
						case "F":
							$level->setBlockRaw($vector, new FenceBlock());
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