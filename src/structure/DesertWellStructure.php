<?php

class DesertWellStructure{
    public static $width = 5;
    public static $structure = [
        -2 => [
            "SSSSS",
            "SSSSS",
            "SSSSS",
            "SSSSS",
            "SSSSS",
        ],
        -1 => [
            "SSSSS",
            "SSWSS",
            "SWWWS",
            "SSWSS",
            "SSSSS",
        ],
        0 => [
            "SSsSS",
            "SS SS",
            "s   s",
            "SS SS",
            "SSsSS",
        ],
        1 => [
            "",
            " S S ",
            "",
            " S S ",
            "",
        ],
        2 => [
            "",
            " S S ",
            "",
            " S S ",
            "",
        ],
        3 => [
            "",
            " sss ",
            " sSs ",
            " sss ",
            "",
        ],
    ];

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
		$offsetX = 0;
		$offsetZ = 0;
		foreach(self::$structure as $layerCount => $layer){
			foreach($layer as $line){
				$line = rtrim($line); //remove useless spaces(only from right)
				foreach(str_split($line) as $char){
                    $vector = new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z - floor(self::$width / 2) + $offsetZ);
					switch($char){
						case "S":
							$level->setBlockRaw($vector, new SandStoneBlock());
							break;
                        case "s":
                            $level->setBlockRaw($vector, new SlabBlock(1));
							break;
                        case "W":
                            $level->setBlockRaw($vector, new WaterBlock());
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