<?php

class BucketItem extends Item{
	private static $possiblenames = array(
		0 => "Bucket",
		1 => "Milk Bucket",
		8 => "Water Bucket",
		10 => "Lava Bucket"
	);
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BUCKET, $meta, $count, "Bucket");
		$this->isActivable = true;
		$this->maxStackSize = 1;
		$this->name = BucketItem::$possiblenames[$this->meta];
	}
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($this->meta === AIR){
			if($target instanceof LiquidBlock && $target->getMetadata() == 0){
				$level->setBlock($target, new AirBlock(), true, false, true);
				if(($player->gamemode & 0x01) === 0){
					$this->meta = match($target->getID()){
						WATER, STILL_WATER => WATER,
						LAVA, STILL_LAVA => LAVA,
						default => 0
					};
				}
				return true;
			}
		}elseif($this->meta === WATER){
			if($block->getID() === AIR || $block instanceof LiquidBlock){
				$water = new WaterBlock();
				$level->setBlock($block, $water, true, false, true);
				//$water->place($this, $player, $block, $target, $face, $fx, $fy, $fz);
				if(($player->gamemode & 0x01) === 0){
					$this->meta = 0;
				}
				return true;
			}
		}elseif($this->meta === LAVA){
			if($block->getID() === AIR || $block instanceof LiquidBlock){
				$lava = new LavaBlock();
				$level->setBlock($block, $lava, true, false, true);
				//$lava->place(clone $this, $player, $block, $target, $face, $fx, $fy, $fz);
				if(($player->gamemode & 0x01) === 0){
					$this->meta = 0;
				}
				return true;
			}
		}
		return false;
	}
}
