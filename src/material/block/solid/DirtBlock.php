<?php

class DirtBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(DIRT, 0, "Dirt");
		$this->isActivable = true;
		$this->hardness = 2.5;
	}

	public function onActivate(Item $item, Player $player){
		if($item->isHoe()){
			if($this->getSide(1)->isTransparent === false) return false;
			if(($player->gamemode & 0x01) === 0){
				$item->useOn($this);
				if($item->getMetadata() >= $item->getMaxDurability()) $player->setSlot($player->slot, new Item(AIR, 0, 0), false);
				else $player->setSlot($player->slot, $item, true);
			}
			$this->level->setBlock($this, BlockAPI::get(FARMLAND, 0), true, false, true);
			return true;
		}
		return false;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_RANDOM){
			if(mt_rand(0, 3) == 0){
				$up = $this->getSide(1);
				if(($up->isTransparent === false) or ($up->isLiquid) or ($up->getID() == 60)) return false;
				if($this->getGrassInRadius()){
					$this->level->setBlock($this, BlockAPI::get(GRASS, 0), true, false, true);
				}
			}
		}
		return BLOCK_UPDATE_RANDOM;
	}

	public function getBlockID($x, $y, $z){
		return $this->level->getBlock(new Vector3($x, $y, $z))->getID();
	}

	public function getGrassInRadius(){
		$x = $this->x;
		$y = $this->y;
		$z = $this->z;
		
		if($this->getBlockID($x+1, $y, $z+1) == 2) return true;
		if($this->getBlockID($x+1, $y, $z) == 2) return true;
		if($this->getBlockID($x+1, $y, $z-1) == 2) return true;
		if($this->getBlockID($x, $y, $z+1) == 2) return true;
		if($this->getBlockID($x, $y, $z-1) == 2) return true;
		if($this->getBlockID($x-1, $y, $z+1) == 2) return true;
		if($this->getBlockID($x-1, $y, $z) == 2) return true;
		if($this->getBlockID($x-1, $y, $z-1) == 2) return true;

		if($this->getBlockID($x+1, $y-1, $z+1) == 2) return true;
		if($this->getBlockID($x+1, $y-1, $z) == 2) return true;
		if($this->getBlockID($x+1, $y-1, $z-1) == 2) return true;
		if($this->getBlockID($x, $y-1, $z+1) == 2) return true;
		if($this->getBlockID($x, $y-1, $z) == 2) return true;
		if($this->getBlockID($x, $y-1, $z-1) == 2) return true;
		if($this->getBlockID($x-1, $y-1, $z+1) == 2) return true;
		if($this->getBlockID($x-1, $y-1, $z) == 2) return true;
		if($this->getBlockID($x-1, $y-1, $z-1) == 2) return true;

		if($this->getBlockID($x+1, $y+1, $z+1) == 2) return true;
		if($this->getBlockID($x+1, $y+1, $z) == 2) return true;
		if($this->getBlockID($x+1, $y+1, $z-1) == 2) return true;
		if($this->getBlockID($x, $y+1, $z+1) == 2) return true;
		if($this->getBlockID($x, $y+1, $z-1) == 2) return true;
		if($this->getBlockID($x-1, $y+1, $z+1) == 2) return true;
		if($this->getBlockID($x-1, $y+1, $z) == 2) return true;
		if($this->getBlockID($x-1, $y+1, $z-1) == 2) return true;

		return false;
	}

}