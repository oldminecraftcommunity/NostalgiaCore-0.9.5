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

class GrassBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(GRASS, 0, "Grass");
		$this->isActivable = true;
		$this->hardness = 3;
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array(DIRT, 0, 1),
		);
	}

	public function onActivate(Item $item, Player $player){
		if($item->getID() === DYE and $item->getMetadata() === 0x0F){
			if(($player->gamemode & 0x01) === 0){
				$player->removeItem(DYE,0x0F,1);
			}
			TallGrassObject::growGrass($this->level, $this, new Random(), 8, 2);
			return true;
		}elseif($item->isHoe()){
			if(($player->gamemode & 0x01) === 0){
				$item->useOn($this);
			}
			$this->level->setBlock($this, new FarmlandBlock());
			return true;
		}
		return false;
	}

	public function onUpdate($type){
		$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
		if($type === BLOCK_UPDATE_RANDOM){
			if(mt_rand(0, 2) == 1){
				if($this->getSide(1)->isTransparent === false){
					$this->level->setBlock($this, BlockAPI::get(DIRT, 0), true, false, true);
					return BLOCK_UPDATE_RANDOM;
				}
			}
			return false;
		}
	}

}