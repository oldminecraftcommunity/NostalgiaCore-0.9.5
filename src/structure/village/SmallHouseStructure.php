<?php

class SmallHouseStructure extends Structure{
	public $width = 5;
    public $length = 5;
	public $name = "Small House";
    protected $structure = [
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
    protected $map = [
		"C" => "CobbleStoneBlock",
		"P" => "PlanksBlock",
		"W" => "WoodBlock",
		"D" => "DirtBlock",
		"G" => "GlassPaneBlock",
		"L" => ["LadderBlock", 2],
		"F" => "FenceBlock",
		" " => "AirBlock"
	];

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

    /*public function build($level, $x, $y, $z, $structure = 0){
		$this->generateFence();

		parent::build($level, $x, $y, $z, self::$tmpStructure);
	}*/ //TODO
}