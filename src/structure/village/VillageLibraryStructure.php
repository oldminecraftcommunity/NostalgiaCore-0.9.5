<?php

class VillageLibraryStructure extends Structure{
    public $width = 9;
	public $lenght = 8;
	public $name = "Library";
    private static $structure = [
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
			"C8PPGGGPC",
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
	private $map = [
		"S" => ["CobbleStoneStairsBlock", 2],
		"C" => "CobbleStoneBlock",
		"P" => "PlanksBlock",
		"W" => "WoodBlock",
		"d" => ["DoorBlock", 64, 0x01],
		"8" => ["DoorBlock", 64, 0x09],
		"G" => "GlassPaneBlock",
		"B" => "BookshelfBlock",
		"F" => "FenceBlock",
		"c" => ["CarpetBlock", 12],
		"1" => ["WoodStairsBlock", 1],
		"2" => ["WoodStairsBlock", 2],
		"3" => ["WoodStairsBlock", 3],
		"T" => "WorkbenchBlock",
		" " => "AirBlock"
	];

	public function __construct(){
		parent::__construct($this->width, $this->lenght, $this->name, $this->map);
	}

    public function build($level, $x, $y, $z, $structure = 0){
		parent::build($level, $x, $y, $z, self::$structure);
	}
}