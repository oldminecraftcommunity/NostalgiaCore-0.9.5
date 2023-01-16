<?php

class SugarcaneBlock extends FlowableBlock{
	public function __construct($meta = 0){
		parent::__construct(SUGARCANE_BLOCK, $meta, "Sugarcane");
		$this->isActivable = true;
		$this->hardness = 0;
	}
	
	public function getDrops(Item $item, Player $player){
		return array(
			array(SUGARCANE, 0, 1),
		);
	}
	
	public function onActivate(Item $item, Player $player){
		if($item->getID() === DYE and $item->getMetadata() === 0x0F){ //Bonemeal
			if($this->getSide(0)->getID() !== SUGARCANE_BLOCK){
				for($y = 1; $y < 3; ++$y){
					$b = $this->level->getBlock(new Vector3($this->x, $this->y + $y, $this->z));
					if($b->getID() === AIR){
						$this->level->setBlock($b, new SugarcaneBlock(), true, false, true);							
						break;
					}
				}
				$this->meta = 0;
				$this->level->setBlock($this, $this, true, false, true);
			}
			if(($player->gamemode & 0x01) === 0){
				$player->removeItem(DYE,0x0F,1);
			}
			return true;
		}
		return false;
	}

	public function onUpdate($type){
		
		$down = $this->getSide(0);
		if($down->getID() === GRASS or $down->getID() === DIRT or $down->getID() === SAND){
			$block0 = $down->getSide(2);
			$block1 = $down->getSide(3);
			$block2 = $down->getSide(4);
			$block3 = $down->getSide(5);
			if(!($block0 instanceof WaterBlock) and !($block1 instanceof WaterBlock) and !($block2 instanceof WaterBlock) and !($block3 instanceof WaterBlock)){
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem(SUGARCANE));
				return true;
			}
		}
		if($type === BLOCK_UPDATE_NORMAL){
			$down = $this->getSide(0);
			if($down->isTransparent === true and $down->getID() !== SUGARCANE_BLOCK){ //Replace with common break method
				ServerAPI::request()->api->entity->drop(new Position($this->x+0.5, $this->y, $this->z+0.5, $this->level), BlockAPI::getItem(SUGARCANE));
				$this->level->setBlock($this, new AirBlock(), false, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}elseif($type === BLOCK_UPDATE_RANDOM){
			if($this->getSide(0)->getID() !== SUGARCANE_BLOCK){
				if($this->meta === 0x0F){
					for($y = 1; $y < 3; ++$y){
						$b = $this->level->getBlock(new Vector3($this->x, $this->y + $y, $this->z));
						if($b->getID() === AIR){
							$this->level->setBlock($b, new SugarcaneBlock(), true, false, true);							
						}
					}
					$this->meta = 0;
					$this->level->setBlock($this, $this, true, false, true);
				}else{
					++$this->meta;
					$this->level->setBlock($this, $this, true, false, true);
				}
				return BLOCK_UPDATE_RANDOM;
			}
		}
		return false;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
			$down = $this->getSide(0);
			if($down->getID() === SUGARCANE_BLOCK){
				$this->level->setBlock($block, new SugarcaneBlock(), true, false, true);
				return true;
			}elseif($down->getID() === GRASS or $down->getID() === DIRT or $down->getID() === SAND){
				$block0 = $down->getSide(2);
				$block1 = $down->getSide(3);
				$block2 = $down->getSide(4);
				$block3 = $down->getSide(5);
				if(($block0 instanceof WaterBlock) or ($block1 instanceof WaterBlock) or ($block2 instanceof WaterBlock) or ($block3 instanceof WaterBlock)){
					$this->level->setBlock($block, new SugarcaneBlock(), true, false, true);
					$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
					return true;
				}
			}
		return false;
	}
}
