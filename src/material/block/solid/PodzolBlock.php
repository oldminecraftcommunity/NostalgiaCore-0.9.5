<?php

class PodzolBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(PODZOL, $meta, "Podzol");
		$this->hardness = 2.5;
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