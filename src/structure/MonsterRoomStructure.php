<?php

class MonsterRoomStructure{
    public static $width = -1;
    public static $structure = [];

    public static function getWidth(){
        self::$structure = [-1 => [], 0 => [], 1 => [], 2 => [], 3 => [], 4 => []];
        return mt_rand(0, 1) === 1 ? self::$width = 7 : self::$width = 9;
    }

    public static function generateFloor(){
        for($i = 0; $i < self::$width; $i++){
            $line = "";
            for($j = 0; $j < self::$width; $j++){
                $line .= Utils::chance(75) ? "M" : "C";
            }
            array_push(self::$structure[-1], $line);
        }
    }

    public static function generateWalls(){
        for($wallsLevel = 0; $wallsLevel < 5; $wallsLevel++){
            for($i = 0; $i < self::$width; $i++){
                $line = "";
                if($i == 0 or ($i == self::$width - 1)){
                    $line = str_repeat("C", self::$width);
                }
                else{
                    $line = self::$width == 7 ? "C     C" : "C       C";
                }
                if($wallsLevel == 0){
                    self::generateChests();
                }
                array_push(self::$structure[$wallsLevel], $line);
            }
        }
    }

    public static function generateChests(){}

    public static function getSpawnerMob(){
        $rand = Utils::randomFloat();
        if($rand <= 0.5) return MOB_ZOMBIE;
        elseif($rand <= 0.75) return MOB_SKELETON;
        else return MOB_SPIDER;
    }

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
        console("building!");
        self::getWidth();
        self::generateFloor();
        self::generateWalls();
        //console(var_dump(self::$structure));
		$offsetX = 0;
		$offsetZ = 0;
		foreach(self::$structure as $layerCount => $layer){
			foreach($layer as $line){
				$line = rtrim($line); //remove useless spaces(only from right)
				foreach(str_split($line) as $char){
					switch($char){
						case "C":
							$level->setBlockRaw(new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z - floor(self::$width / 2) + $offsetZ), new CobblestoneBlock());
							break;
                        case "M":
                            $level->setBlockRaw(new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z - floor(self::$width / 2) + $offsetZ), new MossStoneBlock());
							break;
                        case "H":
                            $level->setBlockRaw(new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z - floor(self::$width / 2) + $offsetZ), new ChestBlock());
							break;
						case " ":
							$block = $level->getBlock(new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z - floor(self::$width / 2) + $offsetZ))->getID();
							if($block == 0){
								break;
							}
							$level->setBlockRaw(new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z - floor(self::$width / 2) + $offsetZ), new AirBlock());
							break;
					}
					++$offsetX;
				}
				++$offsetZ;
				$offsetX = 0;
			}
			$offsetZ = 0;
		}
        $level->setBlockRaw(new Vector3($x, $y, $z), new MonsterSpawnerBlock(self::getSpawnerMob()));
	}
}