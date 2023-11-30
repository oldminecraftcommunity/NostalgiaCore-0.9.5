<?php

abstract class RailBaseBlock extends FlowableBlock //TODO move some methods here
{
	
	public static function isRailBlock(Level $l, $x, $y, $z){
		$id = $l->level->getBlockID($x, $y, $z);
		return $id === POWERED_RAIL || $id === RAIL;
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
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			
			$meta = $this->getMetadata();
			if($this->id === POWERED_RAIL){
				$meta &= 7;
			}
			$x = $this->x;
			$y = $this->y;
			$z = $this->z;
			if(
				($this->level->level->getBlockID($x, $y - 1, $z) == 0) ||
				(($meta == 2) && $this->level->level->getBlockID($x + 1, $y, $z) == 0) ||
				(($meta == 3) && $this->level->level->getBlockID($x - 1, $y, $z) == 0) ||
				(($meta == 4) && $this->level->level->getBlockID($x, $y, $z - 1) == 0) ||
				(($meta == 5) && $this->level->level->getBlockID($x, $y, $z + 1) == 0)
				){
					$this->level->setBlock($this, new AirBlock(), true, false, true);
					ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem($this->id, $this->meta, 1));
			}else{
				$this->updateState();
			}
			
			
			//if($this->getSide(0)->getID() === AIR){//Replace with common break method
			//	ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem($this->id, $this->meta, 1));
			//	$this->level->setBlock($this, new AirBlock(), true, false, true);
			//}
			
		}
		
	}
}
