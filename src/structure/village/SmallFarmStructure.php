<?php

class SmallFarmStructure extends Structure{
    public $width = 7;
	public $length = 9;
	public $name = "Small Farm";
	private static $tmpStructure;
    private static $structure = [
		-1 => [
			//add sand, clay if here isn't air
		],
		0 => [
			"WWWWWWW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WFFwFFW",
			"WWWWWWW",
		]
	];
	private $map = [
		"W" => "WoodBlock",
		"F" => "FarmlandBlock",
		"w" => "WaterBlock",
		"H" => ["WheatBlock", 0],
		"C" => ["CarrotBlock", 0],
		"P" => ["PotatoBlock", 0],
		"B" => ["BeetrootBlock", 0],
		" " => "AirBlock"
	];

	private function generateCrops(){
		self::$tmpStructure = self::$structure;
		$f = Utils::randomFloat();
		if($f <= 0.5){
			parent::setName("Wheat ".$this->name);
			self::$tmpStructure[1] = [
				"",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				" HH HH ",
				"",
			];
		}
		elseif($f <= 0.7){
			parent::setName("Carrot ".$this->name);
			self::$tmpStructure[1] = [
				"",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				" CC CC ",
				"",
			];
		}
		elseif($f <= 0.9){
			parent::setName("Potato ".$this->name);
			self::$tmpStructure[1] = [
				"",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				" PP PP ",
				"",
			];
		}
		else{
			parent::setName("Beetroot ".$this->name);
			self::$tmpStructure[1] = [
				"",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				" BB BB ",
				"",
			];
		}
	}

	public function __construct(){
		parent::__construct($this->width, $this->length, $this->name, $this->map);
	}

    public function build($level, $x, $y, $z, $structure = 0){
		$this->generateCrops();

		parent::build($level, $x, $y, $z, self::$tmpStructure);
	}
}