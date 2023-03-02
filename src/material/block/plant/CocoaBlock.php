<?php

class CocoaBlock extends FlowableBlock{
	protected static $faces = [
		2 => 0x00,
		3 => 0x02,
		4 => 0x03,
		5 => 0x01
	];
	public function __construct($meta = 0){
		parent::__construct(COCOA, $meta, "tile.cocoa.name<");
		$this->isActivable = true;
		$this->hardness = 0;
	}

	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($face === 0 || $face === 1){
			return false; //fix of placing invalid ids without array
		}
		if($target->isTransparent === false){
			$this->level->setBlock($this, BlockAPI::get($this->id, self::$faces[$face]), true, false, true);
			return true;
		}
		return false;
	}
	
	/*public function onActivate(Item $item, Player $player){
		if($item->getID() === DYE and $item->getMetadata() === 0x0F){ //Bonemeal
			$this->meta++;
			if($this->meta > 0x02){
				$this->meta = 0x02;
			}
			$this->level->setBlock($this, $this, true, false, true);
			if(($player->gamemode & 0x01) === 0){
				$player->removeItem(DYE, 0x0F, 1);
			}
			return true;
		}
		return false;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_RANDOM){
			if(mt_rand(0, 2) == 1){
				if($this->meta < 0x03){
					++$this->meta;
					$this->level->setBlock($this, $this, true, false, true);
					return BLOCK_UPDATE_RANDOM;
				}
			}else{
				return BLOCK_UPDATE_RANDOM;
			}
		}
		return false;
	}*/
	
	public function getDrops(Item $item, Player $player){
		$drops = [];
		if($this->meta >= 0x02){ //hum?
			$drops[] = [DYE, 3, mt_rand(1, 4)];
		}else{
			$drops[] = [DYE, 3, 1];
		}
		return $drops;
	}
}
