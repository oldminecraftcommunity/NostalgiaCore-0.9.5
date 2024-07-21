<?php

class StairBlock extends TransparentBlock{
	/**
	 * @param int $id
	 * @param int $meta
	 * @param string $name
	 */
	public function __construct($id, $meta = 0, $name = "Unknown"){
		parent::__construct($id, $meta, $name);
		if(($this->meta & 0x04) === 0x04){
			$this->isFullBlock = true;
		}else{
			$this->isFullBlock = false;
		}
		$this->hardness = 30;
	}
	
	public static function isBlocksStairsID($id){
		return $id > 0 && StaticBlock::getBlock($id) instanceof StairBlock;
	}
	
	public static function isStairsAtXYZAndAreTheirMetadataSame(Level $level, $x, $y, $z, $meta){
		$block = $level->level->getBlock($x, $y, $z);
		return self::isBlocksStairsID($block[0]) && $block[1] == $meta;
	}
	
	public static function setBaseShape(Level $level, $x, $y, $z){
		$meta = $level->level->getBlockDamage($x, $y, $z);
		
		if(($meta & 4) != 0){
			return new AxisAlignedBB(0, 0.5, 0, 1, 1, 1);
		}else{
			return new AxisAlignedBB(0, 0, 0, 1, 0.5, 1);
		}
	}
	
	const DEAD_SAPCES = [
		[2, 6],
		[3, 7],
		[2, 3],
		[6, 7],
		[0, 4],
		[1, 5],
		[0, 1],
		[4, 5]
	];
	
	public static function updateShape(Level $level, $x, $y, $z){
		if(self::$complexState){
			$id = $level->level->getBlockID($x, $y, $z);
			$cid = self::$complexStateID;
			StaticBlock::setBlockBounds($id, 
				0.5 * ($cid % 2),
				0.5 * ((int)($cid / 2) % 2),
				0.5 * ((int)($cid / 4) % 2),
				0.5 + 0.5 * ($cid % 2),
				0.5 + 0.5 * ((int)($cid / 2) % 2),
				0.5 + 0.5 * ((int)($cid / 4) % 2)
			);
		}else{
			StaticBlock::setBlockBounds($level->level->getBlockID($x, $y, $z), 0, 0, 0, 1, 1, 1);
		}
	}
	
	static $complexState = false;
	static $complexStateID = 0;
	public static function clip(Level $level, $x, $y, $z, Vector3 $start, Vector3 $end){
		$v7 = [];
		
		$v8 = $level->level->getBlockDamage($x, $y, $z);
		$v9 = $v8 & 3;
		$v10 = ($v8 & 4) == 4;
		$v11 = self::DEAD_SAPCES[$v9 + ($v10 ? 4 : 0)];
		self::$complexState = true;
		
		for($v12 = 0; $v12 < 8; ++$v12){
			self::$complexStateID = $v12;
			
			for($v15 = 0; $v15 < /*count($v11}*/ 2; ++$v15){
				$v16 = $v11[$v15];
				if($v16 == $v12){
					; //wat
				}
			}
			
			$v7[$v12] = parent::clip($level, $x, $y, $z, $start, $end);
		}
		
		for($v14 = 0; $v14 < /*count($v11}*/ 2; ++$v14){
			$v15 = $v11[$v14];
			$v7[$v15] = null;
		}
		
		$v24 = 0;
		$v22 = null;
		
		for($v17 = 0; $v17 < count($v7); ++$v17){
			$v18 = $v7[$v17];
			
			if($v18 != null){
				$v19 = $v18->hitVector->distanceSquared($end);
				
				if($v19 > $v24){
					$v22 = $v18;
					$v24 = $v19;
				}
			}
		}
		
		return $v22;
	}
	
	public static function setStepShape(Level $level, $x, $y, $z){
		$blockMeta = $level->level->getBlockDamage($x, $y, $z);
		$metaAnd3 = $blockMeta & 3;
		$minY = 0.5;
		$maxY = 1.0;
		if(($blockMeta & 4) != 0){
			$minY = 0.0;
			$maxY = 0.5;
		}
		
		$minX = 0;
		$maxX = 1;
		$minZ = 0;
		$maxZ = 0.5;
		$v13 = true;
		
		switch($metaAnd3){
			case 0:
				$minX = 0.5;
				$maxZ = 1.0;
				$blockNearby = $level->level->getBlock($x + 1, $y, $z);
				$blockIDNearby = $blockNearby[0];
				$blockMetaNearby = $blockNearby[1];
				
				if(self::isBlocksStairsID($blockIDNearby) && (($blockMeta & 4) == ($blockMetaNearby & 4))){
					$blockMetaNearbyAnd3 = $blockMetaNearby & 3;
					
					if($blockMetaNearbyAnd3 == 3 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x, $y, $z + 1, $blockMeta)){
						$maxZ = 0.5;
						$v13 = false;
					}elseif($blockMetaNearbyAnd3 == 2 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x, $y, $z - 1, $blockMeta)){
						$minZ = 0.5;
						$v13 = false;
					}
				}
				break;
			case 1:
				$maxX = 0.5;
				$maxZ = 1.0;
				$blockNearby = $level->level->getBlock($x - 1, $y, $z);
				$blockIDNearby = $blockNearby[0];
				$blockMetaNearby = $blockNearby[1];
				
				if(self::isBlocksStairsID($blockIDNearby) && (($blockMeta & 4) == ($blockMetaNearby & 4))){
					$blockMetaNearbyAnd3 = $blockMetaNearby & 3;
					
					if($blockMetaNearbyAnd3 == 3 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x, $y, $z + 1, $blockMeta)){
						$maxZ = 0.5;
						$v13 = false;
					}elseif($blockMetaNearbyAnd3 == 2 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x, $y, $z - 1, $blockMeta)){
						$minZ = 0.5;
						$v13 = false;
					}
				}
				break;
			case 2:
				$minZ = 0.5;
				$maxZ = 1.0;
				$blockNearby = $level->level->getBlock($x, $y, $z + 1);
				$blockIDNearby = $blockNearby[0];
				$blockMetaNearby = $blockNearby[1];
				
				if(self::isBlocksStairsID($blockIDNearby) && (($blockMeta & 4) == ($blockMetaNearby & 4))){
					$blockMetaNearbyAnd3 = $blockMetaNearby & 3;
					
					if($blockMetaNearbyAnd3 == 1 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x + 1, $y, $z, $blockMeta)){
						$maxX = 0.5;
						$v13 = false;
					}elseif($blockMetaNearbyAnd3 == 0 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x - 1, $y, $z, $blockMeta)){
						$minX = 0.5;
						$v13 = false;
					}
				}
				break;
			case 3:
				$blockNearby = $level->level->getBlock($x, $y, $z - 1);
				$blockIDNearby = $blockNearby[0];
				$blockMetaNearby = $blockNearby[1];
				if(self::isBlocksStairsID($blockIDNearby) && (($blockMeta & 4) == ($blockMetaNearby & 4))){
					$blockMetaNearbyAnd3 = $blockMetaNearby & 3;
					
					if($blockMetaNearbyAnd3 == 1 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x + 1, $y, $z, $blockMeta)){
						$maxX = 0.5;
						$v13 = false;
					}elseif($blockMetaNearbyAnd3 == 0 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x - 1, $y, $z, $blockMeta)){
						$minX = 0.5;
						$v13 = false;
					}
				}
				break;
		}
		return [new AxisAlignedBB($minX, $minY, $minZ, $maxX, $maxY, $maxZ), $v13];
		
	}
	
	public static function setInnerPieceShape(Level $level, $x, $y, $z){
		$meta = $level->level->getBlockDamage($x, $y, $z);
		$metaAnd3 = $meta & 3;
		$minY = 0.5;
		$maxY = 1.0;
		
		if(($meta & 4) != 0){
			$minY = 0.0;
			$maxY = 0.5;
		}
		
		$minX = 0.0;
		$maxX = 0.5;
		$minZ = 0.5;
		$maxZ = 1.0;
		$v13 = false;
		
		switch($metaAnd3){
			case 0:
				$idNearby = $level->level->getBlockID($x - 1, $y, $z);
				$metaNearby = $level->level->getBlockDamage($x - 1, $y, $z);
				
				if(self::isBlocksStairsID($idNearby) && ($meta & 4) == ($metaNearby & 4)){
					$metaNearbyAnd3 = $metaNearby & 3;
					
					if($metaNearbyAnd3 == 3 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x, $y, $z - 1, $meta)){
						$minZ = 0;
						$maxZ = 0.5;
						$v13 = true;
					}elseif($metaNearbyAnd3 == 2 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x, $y, $z + 1, $meta)){
						$minZ = 0.5;
						$maxZ = 1.0;
						$v13 = true;
					}
				}
				break;
			case 1:
				$idNearby = $level->level->getBlockID($x + 1, $y, $z);
				$metaNearby = $level->level->getBlockDamage($x + 1, $y, $z);
				
				if(self::isBlocksStairsID($idNearby) && ($meta & 4) == ($metaNearby & 4)){
					$minX = 0.5;
					$maxX = 1.0;
					$metaNearbyAnd3 = $metaNearby & 3;

					if($metaNearbyAnd3 == 3 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x, $y, $z - 1, $meta)){
						$minZ = 0;
						$maxZ = 0.5;
						$v13 = true;
					}elseif($metaNearbyAnd3 == 2 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x, $y, $z + 1, $meta)){
						$minZ = 0.5;
						$maxZ = 1.0;
						$v13 = true;
					}
				}
				
				break;
			case 2:
				$idNearby = $level->level->getBlockID($x, $y, $z - 1);
				$metaNearby = $level->level->getBlockDamage($x, $y, $z - 1);
				
				if(self::isBlocksStairsID($idNearby) && ($meta & 4) == ($metaNearby & 4)){
					$minZ = 0;
					$maxZ = 0.5;
					$metaNearbyAnd3 = $metaNearby & 3;
					
					if($metaNearbyAnd3 == 1 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x - 1, $y, $z, $meta)){
						$v13 = true;
					}elseif($metaNearbyAnd3 == 0 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x + 1, $y, $z, $meta)){
						$minX = 0.5;
						$maxX = 1.0;
						$v13 = true;
					}
				}
				
				break;
			case 3:
				
				$idNearby = $level->level->getBlockID($x, $y, $z + 1);
				$metaNearby = $level->level->getBlockDamage($x, $y, $z + 1);
				
				if(self::isBlocksStairsID($idNearby) && ($meta & 4) == ($metaNearby & 4)){
					$metaNearbyAnd3 = $metaNearby & 3;
					
					if($metaNearbyAnd3 == 1 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x - 1, $y, $z, $meta)){
						$v13 = true;
					}elseif($metaNearbyAnd3 == 0 && !self::isStairsAtXYZAndAreTheirMetadataSame($level, $x + 1, $y, $z, $meta)){
						$minX = 0.5;
						$maxX = 1.0;
						$v13 = true;
					}
				}
				break;
		}
		
		return [new AxisAlignedBB($minX, $minY, $minZ, $maxX, $maxY, $maxZ), $v13];
	}
	
	public static function getCollisionBoundingBoxes(Level $level, $x, $y, $z, Entity $entity){
		$bbs = [self::setBaseShape($level, $x, $y, $z)->offset($x, $y, $z)];
		$ret = self::setStepShape($level, $x, $y, $z);
		$bbs[] = $ret[0]->offset($x, $y, $z);
		if($ret[1]){
			$ret2 = self::setInnerPieceShape($level, $x, $y, $z);
			if($ret2[1]){
				$bbs[] = $ret2[0]->offset($x, $y, $z);
			}
		}
		
		return $bbs;
	}
	
	/**
	 * @param Item $item
	 * @param Player $player
	 * @param Block $block
	 * @param Block $target
	 * @param int $face
	 * @param int $fx
	 * @param int $fy
	 * @param int $fz
	 *
	 * @return bool|mixed
	 */
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$faces = array(
			0 => 0,
			1 => 2,
			2 => 1,
			3 => 3,
		);
		$this->meta = $faces[$player->entity->getDirection()] & 0x03;
		if(($fy > 0.5 and $face !== 1) or $face === 0){
			$this->meta |= 0x04; //Upside-down stairs
		}
		$this->level->setBlock($block, $this, true, false, true);
		return true;
	}

	/**
	 * @param Item $item
	 * @param Player $player
	 *
	 * @return array
	 */
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array($this->id, 0, 1),
			);
		}else{
			return array();
		}
	}
}