<?php
/*XYZ in Structure String:

|--->x+
|
|z+
*/
abstract class Structure{
	const MAP_NO_KEY = -127;
	const DEG_90 = 0;
	const DEG_180 = 1;
	const DEG_240 = 2;
	
	protected $structure;
	protected $map;
	public $width, $length;
	public $name;
	
	public function __construct(){
		foreach($this->structure as &$s){
			foreach($s as &$e){
				if(strlen($e) < $this->width){
					$e .= str_repeat(" ", $this->width - strlen($e));
				}
			}
		}
	}
	
	protected function getMappingFor($char){
		return $this->map[$char] ?? self::MAP_NO_KEY;
	}
	
	protected function placeBlock(Level $level, $char, $vector){
		if($char === "" || (($mk = $this->getMappingFor($char)) === self::MAP_NO_KEY)) return;
		$id = is_array($mk) ? $mk[0] : $mk;
		$meta = is_array($mk) ? $mk[1] : 0;
		return $level->setBlockRaw($vector, BlockAPI::get($id, $meta));
	}
	
	protected function init(){}
	
	protected function getFinalStructure(Level $level, $x, $y, $z){
		return $this->structure;
	}
	
	public function rotate($rotationLevel = self::DEG_90, $level = null, $x = 0, $y = 0, $z = 0){
		$str = $level instanceof Level ? $this->getFinalStructure($level, $x, $y, $z) : $this->structure;
		var_dump($str);
		switch($rotationLevel){
			case self::DEG_90:
				$l = $this->width;
				$this->width = $this->length;
				$this->length = $l;
				
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
				break;
			case self::DEG_180:
				foreach($str as &$lay){
					$keys = array_keys($lay);
					$ak = count($keys)-1;
					$lay = array_reverse($lay, true);
					foreach($lay as $k => $v){
						unset($lay[$k]);
						$lay[$keys[$ak--]] = strrev($v);
					}
				}
				break;
			case self::DEG_240:
				$l = $this->width;
				$this->width = $this->length;
				$this->length = $l;
				foreach($str as &$arr){
					foreach($arr as &$e){
						$e = str_split(strrev($e));
					}
					$new = [];
					for($i = 0; $i < $this->length; ++$i){
						$new[] = implode("", array_column($arr, $i));
					}
					$arr = $new;
				}
				
				break; //TODO fix
			default:
				ConsoleAPI::warn(self::class." tried to rotate to invalid state($rotationLevel)");
				return $this;
		}
		//var_dump($str);
		$s = (clone $this);
		return $s->setStructure($str, $this->width, $this->length);
	}

	private function setStructure($struct, $width, $length){
		$this->structure = $struct;
		$this->width = $width;
		$this->length = $length;
		ConsoleAPI::debug("Modifed");
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
		console("builded! ".$this->name);
	}
	
}