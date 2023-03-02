<?php

class MyceliumBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(MYCELIUM, 0, "Mycelium");
		$this->isActivable = true;
		$this->hardness = 3;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_RANDOM && !$this->getSide(1)->isTransparent && mt_rand(0, 2) == 1){
			$this->level->setBlock($this, BlockAPI::get(DIRT, 0), true, false, true);
		}
		return BLOCK_UPDATE_RANDOM;
	}

	public function onActivate(Item $item, Player $player){ //uwu
		/*$f = Utils::randomFloat();
		if($f <= 0.33) VillageLibraryStructure::buildStructure($this->level, $this->getX(), $this->getY(), $this->getZ());
		elseif($f <= 0.67) SmallHouseStructure::buildStructure($this->level, $this->getX(), $this->getY(), $this->getZ());
		else WoodHutStructure::buildStructure($this->level, $this->getX(), $this->getY(), $this->getZ());*/
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array(DIRT, 0, 1),
		);
	}
}