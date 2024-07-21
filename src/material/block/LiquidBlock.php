<?php

class LiquidBlock extends TransparentBlock{
	/**
	 * @param int $id
	 * @param int $meta
	 * @param string $name
	 */
	public function __construct($id, $meta = 0, $name = "Unknown"){
		parent::__construct($id, $meta, $name);
		$this->isLiquid = true;
		$this->breakable = false;
		$this->isReplaceable = true;
		$this->isSolid = false;
		$this->isFullBlock = true;
		$this->hardness = 500;
	}
	public static $blockID = 0;
	public static function getDepth(Level $level, $x, $y, $z){
		[$id, $meta] = $level->level->getBlock($x, $y, $z);
		return match(static::$blockID){
			WATER, STILL_WATER => $id == WATER || $id == STILL_WATER ? $meta : -1,
			LAVA, STILL_LAVA => $id == LAVA || $id == STILL_LAVA ? $meta : -1,
			default=> -1
		};
	}
	
	public static function onPlace(Level $level, $x, $y, $z){
		static::updateLiquid($level, $x, $y, $z);
	}
	
	public static function neighborChanged(Level $level, $x, $y, $z, $nX, $nY, $nZ, $oldID){
		static::updateLiquid($level, $x, $y, $z);
	}
	public static function getAABB(Level $level, $x, $y, $z){
		return null;
	}
	public static function getPercentAir($meta){
		if($meta >= 8) $meta = 0;
		$f = ($meta + 1) / 9;
		return $f;
	}
	
	public static function getRenderedDepth(Level $level, $x, $y, $z){
		[$id, $meta] = $level->level->getBlock($x, $y, $z);
		
		$cond = match($id){
			WATER, STILL_WATER => static::$blockID == WATER || static::$blockID == STILL_WATER,
			LAVA, STILL_LAVA => static::$blockID == LAVA || static::$blockID == STILL_LAVA,
			default => static::$blockID == $id
		};
		if(!$cond) return -1;
		return $meta >= 8 ? 0 : $meta;
	}
	
	public static function shouldRenderFace(Level $level, $x, $y, $z, $face){
		$id = $level->level->getBlockID($x, $y, $z);
		
		if($id == ICE) return false;
		if((($id == WATER || $id == STILL_WATER) && (static::$blockID == WATER || static::$blockID == STILL_WATER))) return false;
		if((($id == LAVA || $id == STILL_LAVA) && (static::$blockID == LAVA || static::$blockID == STILL_LAVA))) return false;
		
		if($face == 1) return true;
		return StaticBlock::getIsSolid($id);
		//return parent::shouldRenderFace($level, $x, $y, $z, $face);
	}
	
	public static function getFlow(Level $level, $x, $y, $z){
		$flowVector = new Vector3(0, 0, 0);
		$v6 = static::getRenderedDepth($level, $x, $y, $z);
		
		for($v7 = 0; $v7 < 4; ++$v7){
			$v8 = $x;
			$v10 = $z;
			switch($v7){
				case 0:
					--$v8;
					break;
				case 1:
					--$v10;
					break;
				case 2:
					++$v8;
					break;
				case 3:
					++$v10;
					break;
			}
			
			$v11 = static::getRenderedDepth($level, $v8, $y, $v10);
			if($v11 < 0){
				if(!StaticBlock::getIsSolid($level->level->getBlockID($v8, $y, $v10))){ //TODO material.blocksMovement
					$v11 = static::getRenderedDepth($level, $v8, $y - 1, $v10);
					
					if($v11 >= 0){
						$v12 = $v11 - ($v6 - 8);
						$flowVector->x += ($v8 - $x) * $v12;
						$flowVector->y += ($y - $y) * $v12;
						$flowVector->z += ($v10 - $z) * $v12;
					}
				}
			}else if($v11 >= 0){
				$v12 = $v11 - $v6;
				$flowVector->x += ($v8 - $x) * $v12;
				$flowVector->y += ($y - $y) * $v12;
				$flowVector->z += ($v10 - $z) * $v12;
			}
		}
		
		$meta = $level->level->getBlockDamage($x, $y, $z);
		
		if($meta >= 8){
			$v13 = //TODO more vanilla way to do it
				static::shouldRenderFace($level,  $x, $y, $z - 1, 2) ||
				static::shouldRenderFace($level,  $x, $y, $z + 1, 3) ||
				static::shouldRenderFace($level,  $x - 1, $y, $z, 4) ||
				static::shouldRenderFace($level,  $x + 1, $y, $z, 5) ||
				
				static::shouldRenderFace($level,  $x, $y + 1, $z - 1, 2) ||
				static::shouldRenderFace($level,  $x, $y + 1, $z + 1, 3) ||
				static::shouldRenderFace($level,  $x - 1, $y + 1, $z, 4) ||
				static::shouldRenderFace($level,  $x + 1, $y + 1, $z, 5)
			;
			
			if($v13){
				$ln = $flowVector->length();
				if($ln){
					$flowVector->x /= $ln;
					$flowVector->y = ($flowVector->y / $ln) - 6;
					$flowVector->z /= $ln;
				}else{
					$flowVector->x = $flowVector->y = $flowVector->z = 0;
				}
			}
		}
		$ln = $flowVector->length();
		if($ln){
			$flowVector->x /= $ln;
			$flowVector->y /= $ln;
			$flowVector->z /= $ln;
		}else{
			$flowVector->x = $flowVector->y = $flowVector->z = 0;
		}
		
		return $flowVector;
	}
	
	public static function addVelocityToEntity(Level $level, $x, $y, $z, Entity $entity, Vector3 $velocityVector){
		$flow = static::getFlow($level, $x, $y, $z);
		$velocityVector->x += $flow->x * 0.5;
		$velocityVector->y += $flow->y * 0.5;
		$velocityVector->z += $flow->z * 0.5;
	}
	
	public static function getTickDelay(){
		throw new RuntimeException("If you see this, something bad happened");
	}
	
	public static function updateLiquid(Level $level, $x, $y, $z){
		[$id, $meta] = $level->level->getBlock($x, $y, $z);
		if($id != LAVA && $id != STILL_LAVA) return;
		
		$zNeg = $level->level->getBlockID($x, $y, $z - 1);
		$zPos = $level->level->getBlockID($x, $y, $z + 1);
		$xNeg = $level->level->getBlockID($x - 1, $y, $z);
		$xPos = $level->level->getBlockID($x + 1, $y, $z);
		$yPos = $level->level->getBlockID($x, $y + 1, $z);
		
		if(
				$zNeg == WATER || $zNeg == STILL_WATER
			|| 	$zPos == WATER || $zPos == STILL_WATER
			||	$xNeg == WATER || $xNeg == STILL_WATER
			||	$xPos == WATER || $xPos == STILL_WATER
			||	$yPos == WATER || $yPos == STILL_WATER
		) {
			if($meta){
				//if($meta > 4) -> fizz & ret
				$replacement = COBBLESTONE;
			}else{
				$replacement = OBSIDIAN;
			}
			
			$level->fastSetBlockUpdate($x, $y, $z, $replacement, true);
		}
	}
	
	
	public function getDrops(Item $item, Player $player){
		return array();
	}
	
	public function getLiquidHeight(){
		return (($this->meta >= 8 ? 0 : $this->meta)+1) / 9;
	}
}