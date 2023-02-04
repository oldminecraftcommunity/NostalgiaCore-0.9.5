<?php

class IceBlock extends TransparentBlock{
	public function __construct(){
		parent::__construct(ICE, 0, "Ice");
		$this->hardness = 2.5;
		$this->slipperiness = 0.98;
	}
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$ret = $this->level->setBlock($this, $this, true, false, true);
		$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
		return $ret;
	}
	public function onBreak(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0){
			$this->level->setBlock($this, new WaterBlock(), true, false, true);
			ServerAPI::request()->api->block->scheduleBlockUpdate(clone $this, 10, BLOCK_UPDATE_NORMAL);
		}else{
			$this->level->setBlock($this, new AirBlock(), true, false, true);
		}
		return true;
	}
	/*
		Scan for blocks which can emit light
		args: offsetX: int, offsetY: int, offsetZ: int
		do not set offsets more than 15 : no lighting sources are giving so much light
	*/
	private function scanForNearbyLightSources($offsetX, $offsetY, $offsetZ){ 
		for($x = -$offsetX; $x <= $offsetX; ++$x){ //i hope it is possible to optimize it
			for($z = -$offsetZ; $z <= $offsetZ; ++$z){
				for($y = -$offsetY; $y <= $offsetY; ++$y){
					$pX = $this->x+$x;
					$pY = $this->y+$y;
					$pZ = $this->z+$z;
					$block = $this->level->getBlock(new Vector3($pX, $pY, $pZ));
					if($block instanceof LightingBlock){ //idk is it possible to make it better
						return $block;
					}
				}	
			}	
		}
	}
	public function onUpdate($type){ /*Taken from https://github.com/PocketMine/PocketMine-MP/issues/3249*/
		if($type === BLOCK_UPDATE_RANDOM){
			$light = $this->scanForNearbyLightSources(3,3,3);
			if(LightUtils::getLightValueFromNearbySource($light,$this) > 12){
				$this->level->setBlock($this, new WaterBlock(), true);
				ServerAPI::request()->api->block->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), 10, BLOCK_UPDATE_NORMAL); //additional request for update
			}
			return BLOCK_UPDATE_RANDOM;
		}
		return false;
	}
	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){
			case 5:
				return 0.1;
			case 4:
				return 0.15;
			case 3:
				return 0.2;
			case 2:
				return 0.1;
			case 1:
				return 0.4;
			default:
				return 0.75;
		}
	}

	public function getDrops(Item $item, Player $player){
		return array();
	}
}