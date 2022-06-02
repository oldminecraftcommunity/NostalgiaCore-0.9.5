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

class TallGrassBlock extends FlowableBlock{
	public function __construct($meta = 1){
		parent::__construct(TALL_GRASS, $meta, "Tall Grass");
		$this->isReplaceable = true;
		$names = array(
			0 => "Dead Shrub",
			1 => "Tall Grass",
			2 => "Fern",
		);
		$this->name = $names[$this->meta & 0x03];
		$this->hardness = 0;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->isTransparent === true){//Replace with common break method
				$this->level->setBlock($this, new AirBlock(), false, false, true);
              	if(Utils::chance(15)) ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem(WHEAT_SEEDS));
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){
		$drops = array();
		if($item->isShears()) $drops[] = array($this->id, $this->meta & 0x03, 1);
		elseif(Utils::chance(15)) $drops[] = array(WHEAT_SEEDS, 0, 1);
		return $drops;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() == 2 or $down->getID() == 3){
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		} 
		return false;
	}

}
