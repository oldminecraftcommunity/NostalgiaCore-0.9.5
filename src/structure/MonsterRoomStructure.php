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
                array_push(self::$structure[$wallsLevel], $line);
            }
        }
    }

    public static function generateChests($level, $x, $y, $z){
        $level->setBlockRaw(new Vector3($x - floor(self::$width / 3), $y, $z), new ChestBlock());
        $level->setBlockRaw(new Vector3($x, $y, $z - floor(self::$width / 3)), new ChestBlock());
    }

    /*public static function getSpawnerMob(){
        $rand = Utils::randomFloat();
        if($rand <= 0.5) return MOB_ZOMBIE;
        elseif($rand <= 0.75) return MOB_SKELETON;
        else return MOB_SPIDER;
    }*/

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
        self::getWidth();
        self::generateFloor();
        self::generateWalls();
		$offsetX = 0;
		$offsetZ = 0;
		foreach(self::$structure as $layerCount => $layer){
			foreach($layer as $line){
				$line = rtrim($line); //remove useless spaces(only from right)
				foreach(str_split($line) as $char){
                    $vector = new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z - floor(self::$width / 2) + $offsetZ);
					switch($char){
						case "C":
							$level->setBlockRaw($vector, new CobblestoneBlock());
							break;
                        case "M":
                            $level->setBlockRaw($vector, new MossStoneBlock());
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
        $level->setBlockRaw(new Vector3($x, $y, $z), new MonsterSpawnerBlock());
        self::generateChests($level, $x, $y, $z);
	}

    public static $possibleLoot = [
        "bone", "gunpowder", "string", "wheat", "bread"/*, "saddle"*/, "coal", "redstone_dust", "beetroot_seeds", "melon_seeds", "pumpkin_seeds", "iron_ingot", "bucket", "gold_ingot"
    ];
}