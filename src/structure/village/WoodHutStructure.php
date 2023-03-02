<?php

class WoodHutStructure{
    public static $width = 4;
	public static $lenght = 6;
    public static $structure = [
		0 => [
			" S  ",
			"CCCC",
			"CDDC",
			"CDDC",
			"CDDC",
			"CCCC",
		],
		1 => [
			"",
			"WdPW",
			"P  P",
			"P  P",
			"P FP",
			"WPPW",
		],
		2 => [
			"",
			"WdPW",
			"P  P",
			"G  G",
			"P cP",
			"WPPW",
		],
		3 => [
			"",
			"WPPW",
			"P  P",
			"P  P",
			"P  P",
			"WPPW",
		],
		4 => [
			"",
			" WW ",
			"W  W",
			"W  W",
			"W  W",
			" WW ",
		],
		5 => [
			"",
			"",
			" WW ",
			" WW ",
			" WW ",
			"",
		]
	];

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
		$offsetX = 0;
		$offsetZ = 0;
		foreach(self::$structure as $layerCount => $layer){
			foreach($layer as $line){
				$line = rtrim($line); //remove useless spaces(only from right)
				foreach(str_split($line) as $char){
                    $vector = new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z + $offsetZ);
					switch($char){
						case "S":
							$level->setBlockRaw($vector, new CobbleStoneStairsBlock(2));
							break;
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
						case "d":
							if($layerCount == 1) $level->setBlockRaw($vector, new DoorBlock(WOODEN_DOOR));
							else $level->setBlockRaw($vector, new DoorBlock(WOODEN_DOOR, 0x08));
							break;
						case "G":
							$level->setBlockRaw($vector, new GlassPaneBlock());
							break;
						case "F":
							$level->setBlockRaw($vector, new FenceBlock());
							break;
						case "c":
							$level->setBlockRaw($vector, new CarpetBlock(12));
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