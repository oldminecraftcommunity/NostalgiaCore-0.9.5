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
	public $api, $pm;
	public static $map, $width, $lenght;
	
	public function __construct($width, $lenght, $charToBlock = []){
		$this->pm = ServerAPI::request();
		$this->api = $this->pm->api;
		self::$width = $width;
		self::$lenght = $lenght;
		self::$map = $charToBlock;
		/*foreach($charToBlock as $char => $array){
			$this->addMapping($char, , isset($array) ? $array[1] : 0);
		}*/
	}
	
	public function addMapping($char, $blockClass, $meta){
		self::$map[$char] = new $blockClass($meta);
	}

	public static function getMappingFor($char){
		return isset(self::$map[$char]) ? self::$map[$char] : Structure::MAP_NO_KEY;
	}
	
	protected static function placeBlock($level, $char, &$vector){
		if($char == "") return;
		if($level instanceof Level){
			$blockClass = is_array(self::$map[$char]) ? self::$map[$char][0] : self::$map[$char];
			$block = new $blockClass(isset(self::$map[$char]) ? self::$map[$char][1] : 0, isset(self::$map[$char][2]) ? self::$map[$char][2] : 0);
			//var_dump($block);
			/*if($block === Structure::MAP_NO_KEY){
				//console("Failed to receive id");
				return false;
			}*/
			$level->setBlock($vector, $block, true, false, true);
		}
	}
	
	public static function build($level, $centerX, $centerY, $centerZ, $structure){
		//console("b");
		$offsetX = 0;
		$offsetZ = 0;
		foreach($structure as $offsetY => $blocksXZ){
			foreach($blocksXZ as $blocks){
				$blocks = rtrim($blocks);
				foreach(str_split($blocks) as $block){
					$vector = new Vector3($centerX - floor(self::$width / 2) + $offsetX, $centerY + $offsetY, $centerZ + $offsetZ);
					//$tempVector->setXYZ($x, $centerY + $offsetY, $z);
					self::placeBlock($level, $block, $vector);
					++$offsetX;
				}
				++$offsetZ;
				$offsetX = 0;
			}
			$offsetZ = 0;
		}
	}
	
}