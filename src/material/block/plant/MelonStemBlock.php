<?php

class MelonStemBlock extends FlowableBlock{
	public function __construct($meta = 0){
		parent::__construct(MELON_STEM, $meta, "Melon Stem");
		$this->isActivable = true;
		$this->hardness = 0;
	}
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
			$down = $this->getSide(0);
			if($down->getID() === FARMLAND){
				$this->level->setBlock($block, $this, true, false, true);
				$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
				return true;
			}
		return false;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getID() != 60){
				ServerAPI::request()->api->entity->drop(new Position($this->x+0.5, $this->y, $this->z+0.5, $this->level), BlockAPI::getItem(MELON_SEEDS, 0, mt_rand(0, 2)));
				$this->level->setBlock($this, new AirBlock(), false, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}elseif($type === BLOCK_UPDATE_RANDOM){
			if(mt_rand(0, 2) == 1){
				if($this->meta < 0x07){
					++$this->meta;
					$this->level->setBlock($this, $this, true, false, true);
					return BLOCK_UPDATE_RANDOM;
				}else{
					for($side = 2; $side <= 5; ++$side){
						$b = $this->getSide($side);
						if($b->getID() === MELON_BLOCK){
							return BLOCK_UPDATE_RANDOM;
						}
					}
					$side = $this->getSide(mt_rand(2,5));
					$d = $side->getSide(0);
					if($side->getID() === AIR and ($d->getID() === FARMLAND or $d->getID() === GRASS or $d->getID() === DIRT)){
						$this->level->setBlock($side, new MelonBlock(), true, false, true);
					}
				}
			}
			return BLOCK_UPDATE_RANDOM;
		}
		return false;
	}
	
	public function onActivate(Item $item, Player $player){
		if($item->getID() === DYE and $item->getMetadata() === 0x0F){ //Bonemeal
			$this->meta += mt_rand(0, 3) + 2;
			if ($this->meta > 7) {
				$this->meta = 7;
			}
			$this->level->setBlock($this, $this, true, false, true);
			if(($player->gamemode & 0x01) === 0){
				$player->removeItem(DYE,0x0F,1);
			}
			return true;
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){
		$drops = [];
		if($this->meta >= 0x07){
			$drops[] = [MELON_SEEDS, 0, mt_rand(1, 2)];
		}
		elseif($this->meta >= 0x01 and $this->meta <= 0x07){
			$drops[] = [MELON_SEEDS, 0, 1];
		}
		else{
			$drops[] = [MELON_SEEDS, 0, 0];
		}
		return $drops;
	}
}