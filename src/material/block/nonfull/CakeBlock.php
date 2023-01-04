<?php

class CakeBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(CAKE_BLOCK, 0, "Cake Block");
		$this->isFullBlock = false;
		$this->isActivable = true;
		$this->meta = $meta & 0x07;
		$this->hardness = 2.5;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() !== AIR){
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		}
		return false;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getID() === AIR){ //Replace with common break method
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){
		return array();
	}
	
	public function onActivate(Item $item, Player $player){
		if($player->entity->getHealth() < 20){
			++$this->meta;
			$player->entity->heal(3, "cake");
			if($this->meta >= 0x06){
				$this->level->setBlock($this, new AirBlock(), true, false, true);
			}else{
				$this->level->setBlock($this, $this, true, false, true);
			}
			return true;
		}
		return false;
	}
	
}