<?php

class CactusBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(CACTUS, $meta, "Cactus");
		$this->isFullBlock = false;
		$this->hardness = 2;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			$down = $this->getSide(0);
			$block0 = $this->getSide(2); 
			$block1 = $this->getSide(3);
			$block2 = $this->getSide(4);
			$block3 = $this->getSide(5);
			if($block0->isFlowable === false or $block1->isFlowable === false or $block2->isFlowable === false or $block3->isFlowable === false or ($down->getID() !== SAND and $down->getID() !== CACTUS)){ //Replace with common break method
				$this->level->setBlock($this, new AirBlock(), false);
				ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem($this->id));
				return BLOCK_UPDATE_NORMAL;
			}
		}elseif($type === BLOCK_UPDATE_RANDOM){
			if($this->getSide(0)->getID() !== CACTUS){
				if($this->meta == 0x0F){
					for($y = 1; $y < 3; ++$y){
						$b = $this->level->getBlock(new Vector3($this->x, $this->y + $y, $this->z));
						if($b->getID() === AIR){
							$this->level->setBlock($b, new CactusBlock(), true, false, true);							
							break;
						}
					}
					$this->meta = 0;
					$this->level->setBlock($this, $this, false);
				}else{
					++$this->meta;
					$this->level->setBlock($this, $this, false);
				}
				return BLOCK_UPDATE_RANDOM;
			}
		}
		return false;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() === SAND or $down->getID() === CACTUS){
			$block0 = $this->getSide(2);
			$block1 = $this->getSide(3);
			$block2 = $this->getSide(4);
			$block3 = $this->getSide(5);
			if($block0->isFlowable === true and $block1->isFlowable === true and $block2->isFlowable === true and $block3->isFlowable === true){
				$this->level->setBlock($this, $this, true, false, true);
				$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
				ServerAPI::request()->api->block->scheduleBlockUpdate(clone $this, 10, BLOCK_UPDATE_NORMAL);
				return true;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}
}