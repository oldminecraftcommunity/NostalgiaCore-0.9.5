<?php

class StrongholdPortalRoomStructure extends Structure{
    public $width = 11;
    public $length = 16;
    public $name = "Portal Room";
    protected $structure = [
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
			"S   sms   S",
			"I   SSS   I",
			"S   000   S",
			"I  1   3  I",
			"S  1   3  S",
			"I  1   3  I",
			"S   222   S",
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
    protected $map = [
		"S" => "StoneBricksBlock",
		"M" => ["StoneBricksBlock", 1],
		"C" => ["StoneBricksBlock", 2],
		"I" => "IronBarsBlock",
		"L" => "LavaBlock",
		"s" => ["StoneBrickStairsBlock", 2],
		"m" => "MonsterSpawnerBlock",
		"0" => ["EndPortalFrameBlock", 0],
		"1" => ["EndPortalFrameBlock", 1],
		"2" => ["EndPortalFrameBlock", 2],
		"3" => ["EndPortalFrameBlock", 3],
		"4" => ["EndPortalFrameBlock", 4],
		"5" => ["EndPortalFrameBlock", 5],
		"6" => ["EndPortalFrameBlock", 6],
		"7" => ["EndPortalFrameBlock", 7],
		" " => "AirBlock",
	];

	private function replaceStoneBricks(){
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

	private function placeEyes(){
		$lines = [
			"S   000   S",
			"I  1   3  I",
			"S  1   3  S",
			"I  1   3  I",
			"S   222   S",
		];
		foreach($lines as $id => $str){
			$line = str_split($str);
			for($i = 0; $i < count($line); $i++){
				if(is_numeric($line[$i]) and Utils::chance(10)){
					$line[$i] = strval(intval($line[$i]) + 4);
				}
			}
			self::$tmpStructure[2][8 + $id] = implode("", $line);
		}
	}

	public function __construct(){
		parent::__construct($this->width, $this->length, $this->name, $this->map);
	}

    /*public function build($level, $x, $y, $z, $structure = 0){
        $this->replaceStoneBricks();
		$this->placeEyes();

		parent::build($level, $x, $y, $z, self::$tmpStructure);
	}*/ // TODO
}