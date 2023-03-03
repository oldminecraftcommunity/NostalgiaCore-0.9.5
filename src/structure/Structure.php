<?php
/*XYZ in Structure String:

|--→x+
|
↓z+
*/
abstract class Structure{
	const MAP_NO_KEY = -255;
	const LEVEL_RSV1 = 1;
	private static $structure, $tmpStructure;
	private $map;
	public $api, $pm, $width, $lenght, $name;
	
	public function __construct($width = 0, $lenght = 0, $name = "Unknown", $map = []){
		$this->pm = ServerAPI::request();
		$this->api = $this->pm->api;
		$this->width = $width;
		$this->lenght = $lenght;
		$this->name = $name;
		$this->map = $map;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	protected function getMappingFor($char){
		if(!isset($this->map[$char])) return MAP_NO_KEY;
		$blockClass = is_array($this->map[$char]) ? $this->map[$char][0] : $this->map[$char];
		return new $blockClass(isset($this->map[$char]) ? $this->map[$char][1] : 0, isset($this->map[$char][2]) ? $this->map[$char][2] : 0);
	}
	
	protected function placeBlock($level, $char, &$vector){
		if($char == "") return;
		if($level instanceof Level){
			$block = $this->getMappingFor($char);
			//var_dump($block);
			if($block === Structure::MAP_NO_KEY){
				//console("Failed to get block!");
				return false;
			}
			$level->setBlockRaw($vector, $block);
		}
	}
	
	public function build($level, $centerX, $centerY, $centerZ, $structure = 0){
		//console("building ".$this->name);
		$offsetX = 0;
		$offsetZ = 0;
		foreach($structure as $offsetY => $blocksXZ){
			foreach($blocksXZ as $blocks){
				$blocks = rtrim($blocks);
				foreach(str_split($blocks) as $block){
					if($centerY + $offsetY == 128) return false;
					$vector = new Vector3($centerX - floor($this->width / 2) + $offsetX, $centerY + $offsetY, $centerZ + $offsetZ);
					//$tempVector->setXYZ($x, $centerY + $offsetY, $z);
					$this->placeBlock($level, $block, $vector);
					++$offsetX;
				}
				++$offsetZ;
				$offsetX = 0;
			}
			$offsetZ = 0;
		}
		//console("builded!");
		return true;
	}
	
}