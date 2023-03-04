<?php

class StrongholdLibraryStructure{
    public $width = 14;
    public $length = 15;
    public $structure = [
        -1 => [
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
        ],
        0 => [
            "SSSSSSI ISSSSS",
            "SP        L PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SP BB BB BB PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SP BB BB BB PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SP          PS",
            "SSSSSSSSSSSSSS",
        ],
        1 => [
            "SSSSSSI ISSSSS",
            "SP        L PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SP BB BB BB PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SP BB BB BB PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SP          PS",
            "SSSSSSSSSSSSSS",
        ],
        2 => [
            "SSSSSSIIISSSSS",
            "SPT       L PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SPTBB BB BB PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SPTBB BB BB PS",
            "SB          BS",
            "SB BB BB BB BS",
            "SB          BS",
            "SPT         PS",
            "SSSSSSSSSSSSSS",
        ],
        3 => [
            "SSSSSSIIISSSSS",
            "SP        L PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SSSSSSSSSSSSSS",
        ],
        4 => [
            "SSSSSSSSSSSSSS",
            "SPPPPPPPPPLPPS",
            "SPPPPPPPPPPPPS",
            "SPPP    PPPPPS",
            "SPPP     PPPPS",
            "SPPP      PPPS",
            "SPPP      PPPS",
            "SPPP      PPPS",
            "SPPP      PPPS",
            "SPPP      PPPS",
            "SPPP      PPPS",
            "SPPP      PPPS",
            "SPPPPPPPPPPPPS",
            "SPPPPPPPPPPPPS",
            "SSSSSSSSSSSSSS",
        ],
        5 =>[
            "SSSSSSSSSSSSSS",
            "SP        L PS",
            "SB FFFFFF   BS",
            "SB F    FF  BS",
            "SB F     FF BS",
            "SP F      F PS",
            "SB F      F BS",
            "SB F      F BS",
            "SB F      F BS",
            "SP F      F PS",
            "SB F      F BS",
            "SB F      F BS",
            "SB FFFFFFFF BS",
            "SP          PS",
            "SSSSSSSSSSSSSS",
        ],
        6 =>  [
            "SSSSSSSSSSSSSS",
            "SP        L PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SB    FF    BS",
            "SB   FFFF   BS",
            "SB    FF    BS",
            "SP          PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SSSSSSSSSSSSSS",
        ],
        7 => [
            "SSSSSSSSSSSSSS",
            "SP          PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SB    TT    BS",
            "SB   TFFT   BS",
            "SB    TT    BS",
            "SP          PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SSSSSSSSSSSSSS",
        ],
        8 => [
            "SSSSSSSSSSSSSS",
            "SP          PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SB          BS",
            "SB    FF    BS",
            "SB          BS",
            "SP          PS",
            "SB          BS",
            "SB          BS",
            "SB          BS",
            "SP          PS",
            "SSSSSSSSSSSSSS",
        ],
        9 => [
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
            "SSSSSSSSSSSSSS",
        ]
    ];

    public function replaceStoneBricks(){
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
    
    public function placeCobweb(){
        foreach(self::$tmpStructure as $layerInt => $layer){
            if($layerInt >= 0 and $layerInt <= 3){
                foreach($layer as $key => $str){
                    $line = str_split($str);
                    for($i = 0; $i < count($line); $i++){
                        $str = $line[$i];
                        if($str == " "){
                            if(Utils::chance(5)){
                                $line[$i] = "W";
                            }
                            else{
                                $line[$i] = " ";
                            }
                        }
                    }
                    self::$tmpStructure[$layerInt][$key] = implode("", $line);
                }
            }
		}
    }

    public static function buildStructure($level, $x, $y, $z){ /*use CENTER positions*/
        self::replaceStoneBricks();
        self::placeCobweb();

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
                        case "B":
                            $level->setBlockRaw($vector, new BookshelfBlock());
							break;
                        case "W":
                            $level->setBlockRaw($vector, new CobwebBlock());
							break;
                        case "P":
                            $level->setBlockRaw($vector, new PlanksBlock());
							break;
                        case "T":
                            if($layerCount == 2) $level->setBlockRaw($vector, new TorchBlock(1));
                            else $level->setBlockRaw($vector, new TorchBlock(0));
							break;
                        case "F":
                            $level->setBlockRaw($vector, new FenceBlock());
							break;
                        case "L":
                            $level->setBlockRaw($vector, new LadderBlock(3));
							break;
                        case "I":
                            $level->setBlockRaw($vector, new IronBarsBlock());
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