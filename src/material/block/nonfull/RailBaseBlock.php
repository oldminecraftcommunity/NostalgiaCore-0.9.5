<?php

abstract class RailBaseBlock extends FlowableBlock //TODO move some methods here
{
	
	public static function isRailBlock(Level $l, $x, $y, $z){
		$id = $l->level->getBlockID($x, $y, $z);
		return $id === POWERED_RAIL || $id === RAIL;
	}
	
	public static function isRailID($id){
		return $id == POWERED_RAIL || $id == RAIL;
	}
	
	public static function getAABB(Level $level, $x, $y, $z){
		return null;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() !== AIR and $down instanceof SolidBlock){
			
			$this->level->setBlock($block, $this, true, false, true);
			$logic = new RailLogic($this);
			$logic->place(false, true);
			return true;
		}
		return false;
	}
	
	public function updateState(){}
	
	public static function neighborChanged(Level $level, $x, $y, $z, $nX, $nY, $nZ, $oldID){
		[$id, $meta] = $level->level->getBlock($x, $y, $z);
		if($id === POWERED_RAIL){
			$meta &= 7;
		}
		if(
			($level->level->getBlockID($x, $y - 1, $z) === 0) || 
			(($meta == 2) && $level->level->getBlockID($x + 1, $y, $z) === 0) ||
			(($meta == 3) && $level->level->getBlockID($x - 1, $y, $z) === 0) ||
			(($meta == 4) && $level->level->getBlockID($x, $y, $z - 1) === 0) ||
			(($meta == 5) && $level->level->getBlockID($x, $y, $z + 1) === 0)
		){
			$level->fastSetBlockUpdate($x, $y, $z, 0, 0, true);
			ServerAPI::request()->api->entity->drop(new Position($x, $y, $z, $level), BlockAPI::getItem($id, $meta, 1));
		}else{
			//TODO fix me pls $this->updateState();			
		}
	}
}

