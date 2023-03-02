<?php

class VillageLibraryStructure{
    public static $width = 9;
	public static $lenght = 8;
    public static $structure = [
		0 => [
			" S       ",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"",
		],
		1 => [
			"",
			"CdCCCCCCC",
			"C      TC",
			"C       C",
			"C   F F1C",
			"C  2222PC",
			"CCCCCCCCC",
			"",
		],
		2 => [
			"",
			"CdPPGGGPC",
			"P       P",
			"G       G",
			"G   c c G",
			"P       P",
			"CPGGPGGPC",
			"",
		],
		3 => [
			"",
			"CPPPGGGPC",
			"P       P",
			"G       G",
			"G       G",
			"PBBBBBBBP",
			"CPPPPPPPC",
			"",
		],
		4 => [
			"",
			"CPPPPPPPC",
			"PPPPPPPPP",
			"P       P",
			"P       P",
			"PPPPPPPPP",
			"CPPPPPPPC",
			"",
		],
		5 => [
			"222222222",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"333333333",
		],
		6 => [
			"",
			"222222222",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"333333333",
			"",
		],
		7 => [
			"",
			"",
			"222222222",
			"CCCCCCCCC",
			"CCCCCCCCC",
			"333333333",
			"",
			"",
		],
		8 => [
			"",
			"",
			"",
			"222222222",
			"333333333",
			"",
			"",
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
						case "d":
							if($layerCount == 1) $level->setBlockRaw($vector, new DoorBlock(64));
							else $level->setBlockRaw($vector, new DoorBlock(64, 0x08));
							break;
						case "G":
							$level->setBlockRaw($vector, new GlassPaneBlock());
							break;
						case "B":
							$level->setBlockRaw($vector, new BookshelfBlock());
							break;
						case "F":
							$level->setBlockRaw($vector, new FenceBlock());
							break;
						case "c":
							$level->setBlockRaw($vector, new CarpetBlock(12));
							break;
						case "1":
							$level->setBlockRaw($vector, new WoodStairsBlock(1));
							break;
						case "2":
							$level->setBlockRaw($vector, new WoodStairsBlock(2));
							break;
						case "3":
							$level->setBlockRaw($vector, new WoodStairsBlock(3));
							break;
						case "T":
							$level->setBlockRaw($vector, new WorkbenchBlock());
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