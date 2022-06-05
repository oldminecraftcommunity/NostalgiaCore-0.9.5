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

class FarmlandBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(FARMLAND, $meta, "Farmland");
		$this->hardness = 3;
	}
	public function getDrops(Item $item, Player $player){
		return array(
			array(DIRT, 0, 1),
		);
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(1)->isTransparent === false){
				$this->level->setBlock($this, BlockAPI::get(DIRT, 0), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
			return false;
		}
		if($type === BLOCK_UPDATE_RANDOM){
			if($this->checkWater()){
				$this->level->setBlock($this, BlockAPI::get(FARMLAND, 1), true, false, true);
				return BLOCK_UPDATE_RANDOM;
			}
			else{
				if($this->getSide(1)->isFlowable) return BLOCK_UPDATE_RANDOM;
				$this->level->setBlock($this, BlockAPI::get(DIRT, 0), true, false, true);
				return BLOCK_UPDATE_RANDOM;
			}
		}
		return false;
	}

	public function getBlockID($x, $y, $z){
		return $this->level->getBlock(new Vector3($x, $y, $z))->getID();
	}

	public function checkWater(){
		$x9 = $this->x+4;
		$x8 = $this->x+3;
		$x7 = $this->x+2;
		$x6 = $this->x+1;
		$x5 = $this->x;
		$x4 = $this->x-1;
		$x3 = $this->x-2;
		$x2 = $this->x-3;
		$x1 = $this->x-4;
		
		$y = $this->y;
		$z = $this->z;
	
		for($i = 1; $i < 82; $i++){
			switch($i){
				case($i < 10):
					$z9 = $z + 5 - $i;
					if($this->getBlockID($x9, $y, $z9) == 8 or $this->getBlockID($x9, $y, $z9) == 9) return true;
					break;
				case($i < 19):
					$z8 = $z + 5 - ($i - 9);
					if($this->getBlockID($x8, $y, $z8) == 8 or $this->getBlockID($x8, $y, $z8) == 9) return true;
					break;
				case($i < 28):
					$z7 = $z + 5 - ($i - 18);
					if($this->getBlockID($x7, $y, $z7) == 8 or $this->getBlockID($x7, $y, $z7) == 9) return true;
					break;
				case($i < 37):
					$z6 = $z + 5 - ($i - 27);
					if($this->getBlockID($x6, $y, $z6) == 8 or $this->getBlockID($x6, $y, $z6) == 9) return true;
					break;
				case($i < 46):
					$z5 = $z + 5 - ($i - 36);
					if($this->getBlockID($x5, $y, $z5) == 8 or $this->getBlockID($x5, $y, $z5) == 9) return true;
					break;
				case($i < 55):
					$z4 = $z + 5 - ($i - 45);
					if($this->getBlockID($x4, $y, $z4) == 8 or $this->getBlockID($x4, $y, $z4) == 9) return true;
					break;
				case($i < 64):
					$z3 = $z + 5 - ($i - 54);
					if($this->getBlockID($x3, $y, $z3) == 8 or $this->getBlockID($x3, $y, $z3) == 9) return true;
					break;
				case($i < 73):
					$z2 = $z + 5 - ($i - 63);
					if($this->getBlockID($x2, $y, $z2) == 8 or $this->getBlockID($x2, $y, $z2) == 9) return true;
					break;
				case($i < 82):
					$z1 = $z + 5 - ($i - 72);
					if($this->getBlockID($x1, $y, $z1) == 8 or $this->getBlockID($x1, $y, $z1) == 9) return true;
					break;
			}
		}
		return false;
	}
}