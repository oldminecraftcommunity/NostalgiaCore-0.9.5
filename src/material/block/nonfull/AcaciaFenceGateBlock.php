<?php

class AcaciaFenceGateBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(ACACIA_FENCE_GATE, $meta, "Acacia Fence Gate");
		$this->isActivable = true;
		if(($this->meta & 0x04) === 0x04){
			$this->isFullBlock = true;
		}else{
			$this->isFullBlock = false;
		}
		$this->hardness = 15;
	}
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$faces = array(
			0 => 3,
			1 => 0,
			2 => 1,
			3 => 2,
		);
		$this->meta = $faces[$player->entity->getDirection()] & 0x03;
		$this->level->setBlock($block, $this, true, false, true);
		return true;
	}
	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}
	public function onActivate(Item $item, Player $player){
				$this->meta ^= 0x04;
		$this->level->setBlock($this, $this, true, false, true);
		$players = ServerAPI::request()->api->player->getAll($this->level);
		unset($players[$player->CID]);
		$pk = new LevelEventPacket;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->evid = 1003;
		$pk->data = 0;
		ServerAPI::request()->api->player->broadcastPacket($players, $pk);
		return true;
	}	
}
