<?php

class FenceBlock extends TransparentBlock{
	public static $blockID;
	public function __construct(){
		parent::__construct(FENCE, 0, "Fence");
		$this->isFullBlock = false;
		$this->hardness = 15;
	}
	
	public static function canConnectTo(Level $level, $x, $y, $z){
		$id = $level->level->getBlockID($x, $y, $z);
		
		if($id != FENCE && $id != FENCE_GATE){
			return StaticBlock::getIsSolid($id) && $id != PUMPKIN; //TODO check var6 != null && var6.blockMaterial.isOpaque() && var6.renderAsNormalBlock() ? var6.blockMaterial != Material.pumpkin : false;
		}
		return true;
	}
	
	public static function getCollisionBoundingBoxes(Level $level, $x, $y, $z, Entity $entity){
		$v8 = self::canConnectTo($level, $x, $y, $z - 1);
		$v9 = self::canConnectTo($level, $x, $y, $z + 1);
		$v10 = self::canConnectTo($level, $x - 1, $y, $z);
		$v11 = self::canConnectTo($level, $x + 1, $y, $z);
		$v12 = 0.375;
		$v13 = 0.625;
		$v14 = $v8 ? 0 : 0.375;
		$v15 = $v9 ? 1 : 0.625;
		$arr = [];
		if($v8 || $v9){
			$arr[] = new AxisAlignedBB($x + $v12, $y + 0, $z + $v14, $x + $v13, $y + 1.5, $z + $v15);
		}
		$v14 = 0.375;
		$v15 = 0.625;
		if($v10) $v12 = 0;
		if($v11) $v13 = 1;
		
		if($v10 || $v11 || !$v8 && !$v9){
			$arr[] = new AxisAlignedBB($x + $v12, $y + 0, $z + $v14, $x + $v13, $y + 1.5, $z + $v15);
		}
		return $arr;
	}
	
}