<?php

class SmallHouseStructure extends Structure{
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
			"P   P",
			"CPPPC",
		],
		2 => [
			"CP PC",
			"P   P",
			"G   G",
			"P   P",
			"CPPPC",
		],
		3 => [
			"CPPPC",
			"P   P",
			"P   P",
			"P   P",
			"CPPPC",
		],
		4 => [
			"WWWWW",
			"WPPPW",
			"WPPPW",
			"WPPPW",
			"WWWWW",
		],
	];

	public static $map = [
		"C" => "CobbleStoneBlock",
		"P" => "PlanksBlock",
		"W" => "WoodBlock",
		"D" => "DirtBlock",
		"G" => "GlassPaneBlock",
		"L" => ["LadderBlock", 2],
		"F" => "FenceBlock",
		" " => "AirBlock"
	];

	public function __construct($width = 0, $lenght = 0, $charToBlock = []){
		parent::__construct(self::$width, self::$lenght, self::$map);
	}

	public static function generateFence(){
		self::$tmpStructure = self::$structure; 
		if(Utils::chance(50)){
			self::$tmpStructure[1][3] = "P L P";
			self::$tmpStructure[2][3] = "P L P";
			self::$tmpStructure[3][3] = "P L P";
			self::$tmpStructure[4][3] = "WPLPW";
			self::$tmpStructure[5] = [
				"FFFFF",
				"F   F",
				"F   F",
				"F   F",
				"FFFFF",
			];
		}
	}

    public static function build($level, $x, $y, $z, $structure = []){
		self::generateFence();

		parent::build($level, $x, $y, $z, self::$tmpStructure);
	}
}