<?php

class SmallHouseStructure extends Structure{
    public $width = 5;
	public $lenght = 5;
	public $name = "Small House";
	private static $tmpStructure;
    private static $structure = [
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
	private $map = [
		"C" => "CobbleStoneBlock",
		"P" => "PlanksBlock",
		"W" => "WoodBlock",
		"D" => "DirtBlock",
		"G" => "GlassPaneBlock",
		"L" => ["LadderBlock", 2],
		"F" => "FenceBlock",
		" " => "AirBlock"
	];

	public function __construct(){
		parent::__construct($this->width, $this->lenght, $this->name, $this->map);
	}

	private function generateFence(){
		self::$tmpStructure = self::$structure; 
		if(Utils::chance(50)){
			parent::setName($this->name." with Fence");
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

    public function build($level, $x, $y, $z, $structure = 0){
		$this->generateFence();

		parent::build($level, $x, $y, $z, self::$tmpStructure);
	}
}