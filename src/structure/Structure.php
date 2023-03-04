<?php
/*XYZ in Structure String:

|--->x+
|
|z+
*/
abstract class Structure{
	const MAP_NO_KEY = -127;
	protected $structure;
	protected $map;
	public $width, $length;
	public $name;
	
	public function __construct(){
		foreach($this->structure as &$s){
			foreach($s as &$e){
				if(strlen($e) < $this->length){
					$e .= str_repeat(" ", $this->length - strlen($e));
				}
			}
		}
	}
	
	protected function getMappingFor($char){
		return nullsafe($this->map[$char], self::MAP_NO_KEY);
	}
	
	protected function placeBlock(Level $level, $char, $vector){
		if($char === "" || (($mk = $this->getMappingFor($char)) === self::MAP_NO_KEY)) return;
		$id = is_array($mk) ? $mk[0] : $mk;
		$meta = is_array($mk) ? $mk[1] : 0;
		return $level->setBlock($vector, BlockAPI::get($id, $meta));
	}
	
	protected function init(){}
	
	protected function getFinalStructure(Level $level, $x, $y, $z){
		return $this->structure;
	}
	public function rotate90deg(Level $level, $x, $y, $z){
		$str = $this->getFinalStructure($level, $x, $y, $z);
		foreach($str as &$arr){
			foreach($arr as &$e){
				$e = str_split($e);
			}
			$new = [];
			for($i = 0; $i < $this->length; ++$i){
				$new[] = implode("", array_reverse(array_column($arr, $i)));
			}
			$arr = $new;
		}
		return (clone $this)->setStructure($str, $this->length, $this->width);
	}
	private function setStructure($struct, $width, $length){
		$this->structure = $struct;
		$this->width = $width;
		$this->length = $length;
		console("Modifed");
		return $this;
	}
	public function build(Level $level, $centerX, $centerY, $centerZ){
		$offsetX = $offsetZ = 0;
		$centWidth = floor($this->width / 2);
		$centLength = floor($this->length / 2);
		foreach($this->getFinalStructure($level, $centerX, $centerY, $centerZ) as $offsetY => $blocksXZ){
			foreach($blocksXZ as $blocks){
				$blocks = rtrim($blocks);
				foreach(str_split($blocks) as $block){
					if($centerY + $offsetY == 128) return false;
					$this->placeBlock($level, $block, new Vector3($centerX - $centWidth + $offsetX, $centerY + $offsetY, $centerZ - $centLength + $offsetZ));
					++$offsetX;
				}
				++$offsetZ;
				$offsetX = 0;
			}
			$offsetZ = 0;
		}
	}
	
}