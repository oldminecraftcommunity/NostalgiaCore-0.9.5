<?php

class StrongholdLibraryStructure{
    public static $width = 14;
    public static $structure = [-1 => []];

    public static function generateFloor(){
        for($i = 0; $i < self::$width; $i++){
            $line = "";
            for($j = 0; $j < self::$width; $j++){
                if(Utils::chance(33)){
                    $line .= "S";
                }
                else{
                    $line .= Utils::chance(50) ? "m" : "c";
                }
            }
            array_push(self::$structure[-1], $line);
        }
    }

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
        self::generateFloor();
		$offsetX = 0;
		$offsetZ = 0;
		foreach(self::$structure as $layerCount => $layer){
			foreach($layer as $line){
				$line = rtrim($line); //remove useless spaces(only from right)
				foreach(str_split($line) as $char){
                    $vector = new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z - floor(self::$width / 2) + $offsetZ);
					switch($char){
						case "S":
							$level->setBlockRaw($vector, new StoneBricksBlock(0));
							break;
                        case "m":
                            $level->setBlockRaw($vector, new StoneBricksBlock(1));
							break;
                        case "c":
                            $level->setBlockRaw($vector, new StoneBricksBlock(2));
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
        self::$structure = [-1 => []];
	}
}