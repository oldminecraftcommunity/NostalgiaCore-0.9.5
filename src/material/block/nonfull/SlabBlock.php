<?php

class SlabBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(SLAB, $meta, "Slab");
		$names = array( //TODO make it static
			0 => "Stone",
			1 => "Sandstone",
			2 => "Wooden",
			3 => "Cobblestone",
			4 => "Brick",
			5 => "Stone Brick",
			6 => "Quartz",
			7 => "", //hum?
		);
		$this->name = (($this->meta & 0x08) === 0x08 ? "Upper ":"") . $names[$this->meta & 0x07] . " Slab";	
		if(($this->meta & 0x08) === 0x08){
			$this->isFullBlock = true;
		}else{
			$this->isFullBlock = false;
		}		
		$this->hardness = 30;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
			$this->meta &= 0x07;
			if($face === 0){
				if($target->getID() === SLAB and ($target->getMetadata() & 0x08) === 0x08 and ($target->getMetadata() & 0x07) === ($this->meta & 0x07)){
					$this->level->setBlock($target, BlockAPI::get(DOUBLE_SLAB, $this->meta), true, false, true);
					return true;
				}elseif($block->getID() === SLAB and ($block->getMetadata() & 0x07) === ($this->meta & 0x07)){
					$this->level->setBlock($block, BlockAPI::get(DOUBLE_SLAB, $this->meta), true, false, true);
					return true;
				}else{
					$this->meta |= 0x08;
				}
			}elseif($face === 1){
				if($target->getID() === SLAB and ($target->getMetadata() & 0x08) === 0 and ($target->getMetadata() & 0x07) === ($this->meta & 0x07)){
					$this->level->setBlock($target, BlockAPI::get(DOUBLE_SLAB, $this->meta), true, false, true);
					return true;
				}elseif($block->getID() === SLAB and ($block->getMetadata() & 0x07) === ($this->meta & 0x07)){
					$this->level->setBlock($block, BlockAPI::get(DOUBLE_SLAB, $this->meta), true, false, true);
					return true;
				}
			}elseif(!$player->entity->inBlock($block)){
				if($block->getID() === SLAB){
					if(($block->getMetadata() & 0x07) === ($this->meta & 0x07)){
						$this->level->setBlock($block, BlockAPI::get(DOUBLE_SLAB, $this->meta), true, false, true);
						return true;
					}
					return false;
				}else{
					if($fy > 0.5){
						$this->meta |= 0x08;
					}
				}
			}else{
				return false;
			}
			if($block->getID() === SLAB and ($target->getMetadata() & 0x07) !== ($this->meta & 0x07)){
				return false;
			}
			$this->level->setBlock($block, $this, true, false, true);
			return true;
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){
			case 5:
				return 0.4;
			case 4:
				return 0.5;
			case 3:
				return 0.75;
			case 2:
				return 0.25;
			case 1:
				return 1.5;
			default:
				return 10;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array($this->id, $this->meta & 0x07, 1),
			);
		}else{
			return array();
		}
	}
}