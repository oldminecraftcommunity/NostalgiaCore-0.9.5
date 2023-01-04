<?php

class SignPostBlock extends TransparentBlock{
	
	private $faces = array(
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
	);
	
	public function __construct($meta = 0){
		parent::__construct(SIGN_POST, $meta, "Sign Post");
		$this->isSolid = false;
		$this->isFullBlock = false;
		$this->hardness = 5;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($target->isSolid && $face !== 0){
			if(!isset($this->faces[$face])){
				$this->meta = floor((($player->entity->yaw + 180) * 16 / 360) + 0.5) & 0x0F;
				$this->level->setBlock($block, BlockAPI::get(SIGN_POST, $this->meta), true, false, true);
				return true;
			}else{
				$this->meta = $this->faces[$face];
				$this->level->setBlock($block, BlockAPI::get(WALL_SIGN, $this->meta, true, false, true));
				return true;
			}
		}
		return false;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getID() === AIR){ //Replace with common break method
				ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem(SIGN, 0, 1));
				$this->level->setBlock($this, new AirBlock(), true, true, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function onBreak(Item $item, Player $player){
		$this->level->setBlock($this, new AirBlock(), true, true, true);
		return true;
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array(SIGN, 0, 1),
		);
	}	
}