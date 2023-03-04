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
		//$oldtime = microtime(true);
		//if(mt_rand(0, 1) === 0){
		//	Structures::$SMALLFARM_VILLAGE->rotate(Structure::DEG_240, $this->level)->build($this->level, $this->x, $this->y, $this->z);
		//}else{
		//	Structures::$SMALLFARM_VILLAGE->build($this->level, $this->x, $this->y, $this->z);
		//}
		//$time = microtime(true);
		//console("builded in ".($time - $oldtime));
		
		//(new WoodHutStructure())->build($this->level, $this->getX(), $this->getY(), $this->getZ());
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array(DIRT, 0, 1),
		);
	}
}