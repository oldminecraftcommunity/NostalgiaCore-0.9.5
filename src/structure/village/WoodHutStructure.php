<?php

class WoodHutStructure extends Structure{
	public $width = 4;
	public $length = 6;
	public $name = "Wood Hut";
    protected $structure = [
		0 => [
			" S  ",
			"CCCC",
			"CDDC",
			"CDDC",
			"CDDC",
			"CCCC",
		],
		1 => [
			"",
			"WdPW",
			"P  P",
			"P  P",
			"P  P",
			"WPPW",
		],
		2 => [
			"",
			"W8PW",
			"P  P",
			"G  G",
			"P  P",
			"WPPW",
		],
		3 => [
			"",
			"WPPW",
			"P  P",
			"P  P",
			"P  P",
			"WPPW",
		],
	];
    protected $map = [
		"S" => ["CobbleStoneStairsBlock", 2],
		"C" => "CobbleStoneBlock",
		"P" => "PlanksBlock",
		"W" => "WoodBlock",
		"D" => "DirtBlock",
		"d" => ["DoorBlock", 64, 0x01],
		"8" => ["DoorBlock", 64, 0x09],
		"G" => "GlassPaneBlock",
		"F" => "FenceBlock",
		"c" => ["CarpetBlock", 12],
		" " => "AirBlock"
	];

	public function generateRoof(){
		self::$tmpStructure = self::$structure;
		if(Utils::chance(50)){
			self::$tmpStructure[4] = [
				"",
				" WW ",
				"W  W",
				"W  W",
				"W  W",
				" WW ",
			];
			self::$tmpStructure[5] = [
				"",
				"",
				" WW ",
				" WW ",
				" WW ",
				"",
			];
		}
		else{
			self::$tmpStructure[4] = [
				"",
				" WW ",
				"WWWW",
				"WWWW",
				"WWWW",
				" WW ",
			];
		}
	}

	public function generateTable(){
		if(Utils::chance(66)){
			parent::setName($this->name." with Table");
			self::$tmpStructure[1][4] = "P FP";
			self::$tmpStructure[2][4] = "P cP";
		}
	}

    /*public function build($level, $x, $y, $z, $structure = 0){
		$this->generateRoof();
		$this->generateTable();

		parent::build($level, $x, $y, $z, self::$tmpStructure);
	}*/ //TODO
}