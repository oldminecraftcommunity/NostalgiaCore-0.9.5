<?php

/**
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

class DirtBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(DIRT, 0, "Dirt");
		$this->isActivable = true;
		$this->hardness = 2.5;
	}

	public function onActivate(Item $item, Player $player){
		if($item->isHoe()){
			if(($player->gamemode & 0x01) === 0){
				$item->useOn($this);
			}
			$this->level->setBlock($this, BlockAPI::get(FARMLAND, 0), true, false, true);
			return true;
		}
		return false;
	}

	public function onUpdate($type){
		$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
		if($type === BLOCK_UPDATE_RANDOM){
			if(mt_rand(0, 3) == 0){
				if($this->getSide(1)->isTransparent === false) return false;
				if($this->getGrassInRadius() == true){
					$this->level->setBlock($this, BlockAPI::get(GRASS, 0), true, false, true);
					return BLOCK_UPDATE_RANDOM;
				}
			}
		}
		return false;
	}

	public function getBlockID($x, $y, $z){
		return $this->level->getBlock(new Vector3($x, $y, $z))->getID();
	}

	public function getGrassInRadius(){
		$x = $this->x;
		$y = $this->y;
		$z = $this->z;

		if($this->getBlockID($x+1, $y, $z+1) == 2) return true;
		if($this->getBlockID($x+1, $y, $z) == 2) return true;
		if($this->getBlockID($x+1, $y, $z-1) == 2) return true;
		if($this->getBlockID($x, $y, $z+1) == 2) return true;
		if($this->getBlockID($x, $y, $z-1) == 2) return true;
		if($this->getBlockID($x-1, $y, $z+1) == 2) return true;
		if($this->getBlockID($x-1, $y, $z) == 2) return true;
		if($this->getBlockID($x-1, $y, $z-1) == 2) return true;

		if($this->getBlockID($x+1, $y-1, $z+1) == 2) return true;
		if($this->getBlockID($x+1, $y-1, $z) == 2) return true;
		if($this->getBlockID($x+1, $y-1, $z-1) == 2) return true;
		if($this->getBlockID($x, $y-1, $z+1) == 2) return true;
		if($this->getBlockID($x, $y-1, $z) == 2) return true;
		if($this->getBlockID($x, $y-1, $z-1) == 2) return true;
		if($this->getBlockID($x-1, $y-1, $z+1) == 2) return true;
		if($this->getBlockID($x-1, $y-1, $z) == 2) return true;
		if($this->getBlockID($x-1, $y-1, $z-1) == 2) return true;

		if($this->getBlockID($x+1, $y+1, $z+1) == 2) return true;
		if($this->getBlockID($x+1, $y+1, $z) == 2) return true;
		if($this->getBlockID($x+1, $y+1, $z-1) == 2) return true;
		if($this->getBlockID($x, $y+1, $z+1) == 2) return true;
		if($this->getBlockID($x, $y+1, $z-1) == 2) return true;
		if($this->getBlockID($x-1, $y+1, $z+1) == 2) return true;
		if($this->getBlockID($x-1, $y+1, $z) == 2) return true;
		if($this->getBlockID($x-1, $y+1, $z-1) == 2) return true;

		return false;
	}

}