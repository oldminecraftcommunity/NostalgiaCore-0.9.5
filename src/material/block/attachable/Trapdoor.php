<?php

class TrapdoorBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(TRAPDOOR, $meta, "Trapdoor");
		$this->isActivable = true;
		if(($this->meta & 0x04) === 0x04){
			$this->isFullBlock = false;
		}else{
			$this->isFullBlock = true;
		}
		$this->hardness = 15;
	}
	
	public function canAttachTo(Block $target){
		$id = $target->getID();
		return $id === SLAB || $id === GLOWSTONE || $id === SLAB || $id === WOOD_SLAB || (!$target->isTransparent || $target instanceof StairBlock);
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
			if(($this->canAttachTo($target)) and $face !== 0 and $face !== 1){
				$faces = array(
					2 => 0,
					3 => 1,
					4 => 2,
					5 => 3,
				);
				$this->meta = $faces[$face] & 0x03;
				$this->level->setBlock($block, $this, true, false, true);
				return true;
			}
	}
	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			$faces = array( //meta => side
					0 => 3,
					4 => 3, //activated
					1 => 2,
					5 => 2, //activated
					2 => 5,
					6 => 5, //activated
					3 => 4,
					7 => 4, //activated
			);
			$side = $faces[$this->meta];
			if($this->getSide($side) instanceof AirBlock){ //Replace with common break method
				ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem($this->id, 0, 1));
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
	}
	public function onActivate(Item $item, Player $player){
		$this->meta ^= 0x04;
		$this->level->setBlock($this, $this, true, false, true);
		return true;
	}
}