<?php

class StrongholdPortalRoomStructure{
    public static $width = 11;
	public static $length = 16;
	public static $tmpStructure = [];
    public static $structure = [
		-1 => [
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
		],
		0 => [
			"SSSSI ISSSS",
			"SLS     SLS",
			"SLS     SLS",
			"SLS     SLS",
			"SSS sss SSS",
			"S   SSS   S",
			"S   SSS   S",
			"S   SSS   S",
			"S  SSSSS  S",
			"S  SLLLS  S",
			"S  SLLLS  S",
			"S  SLLLS  S",
			"S  SSSSS  S",
			"S         S",
			"S         S",
			"SSSSSSSSSSS",
		],
		1 => [
			"SSSSI ISSSS",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S   sss   S",
			"S   SSS   S",
			"S   SSS   S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"SSSSSSSSSSS",
		],
		2 => [
			"SSSSIIISSSS",
			"S         S",
			"S         S",
			"I         I",
			"S         S",
			"I         I",
			"S   s1s   S",
			"I   SSS   I",
			"S   PPP   S",
			"I  P   P  I",
			"S  P   P  S",
			"I  P   P  I",
			"S   PPP   S",
			"I         I",
			"S         S",
			"SSSSSSSSSSS",
		],
		3 => [
			"SSSSSSSSSSS",
			"S         S",
			"S         S",
			"I         I",
			"S         S",
			"I         I",
			"S         S",
			"I         I",
			"S         S",
			"I         I",
			"S         S",
			"I         I",
			"S         S",
			"I         I",
			"S         S",
			"SSSSSSSSSSS",
		],
		4 => [
			"SSSSSSSSSSS",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"S         S",
			"SSSSSSSSSSS",
		],
		5 => [
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
			"SSSSSSSSSSS",
		]
	];

	public static function replaceStoneBricks(){
		foreach(self::$structure as $layerInt => $layer){
			foreach($layer as $key => $str){
				$line = str_split($str);
				for($i = 0; $i < count($line); $i++){
					$str = $line[$i];
					if($str == "S"){
						if(Utils::chance(33)){
							$line[$i] = "S";
						}
						else{
							$line[$i] = Utils::chance(50) ? "M" : "C";
						}
					}
				}
				self::$tmpStructure[$layerInt][$key] = implode("", $line);
			}
		}
	}

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
        self::replaceStoneBricks();

		$offsetX = 0;
		$offsetZ = 0;
		foreach(self::$tmpStructure as $layerCount => $layer){
			foreach($layer as $line){
				$line = rtrim($line); //remove useless spaces(only from right)
				foreach(str_split($line) as $char){
                    $vector = new Vector3($x - floor(self::$width / 2) + $offsetX, $y + $layerCount, $z + $offsetZ);
					switch($char){
						case "S":
							$level->setBlockRaw($vector, new StoneBricksBlock(0));
							break;
                        case "M":
                            $level->setBlockRaw($vector, new StoneBricksBlock(1));
							break;
                        case "C":
                            $level->setBlockRaw($vector, new StoneBricksBlock(2));
							break;
						case "I":
							$level->setBlockRaw($vector, new IronBarsBlock());
							break;
						case "L":
							$level->setBlockRaw($vector, new LavaBlock());
							break;
						case "s":
							$level->setBlockRaw($vector, new StoneBrickStairsBlock(2));
							break;
						case "1":
							$level->setBlockRaw($vector, new MonsterSpawnerBlock());
							break;
						case "P":
							$level->setBlockRaw($vector, new EndPortalFrameBlock(mt_rand(0, 4)));
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