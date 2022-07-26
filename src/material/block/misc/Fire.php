<?php

class FireBlock extends FlowableBlock implements LightingBlock{
	public function __construct($meta = 0){
		parent::__construct(FIRE, $meta, "Fire");
		$this->isReplaceable = true;
		$this->breakable = false;
		$this->isFullBlock = true;
		$this->hardness = 0;
	}
	
	public function getDrops(Item $item, Player $player){
		return array();
	}
	public function getMaxLightValue(){
		return 15;
	}
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			for($s = 0; $s <= 5; ++$s){
				$side = $this->getSide($s);
				if($side->getID() !== AIR and !($side instanceof LiquidBlock)){
					return false;
				}
			}
			$this->level->setBlock($this, new AirBlock(), true, false, true);
			return BLOCK_UPDATE_NORMAL;
		}elseif($type === BLOCK_UPDATE_RANDOM){
			if($this->getSide(0)->getID() !== NETHERRACK){
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
}