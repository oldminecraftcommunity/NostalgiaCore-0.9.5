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
				if($this->getRadiusGrass() > 0){
					$this->level->setBlock($this, BlockAPI::get(GRASS, 0), true, false, true);
					return BLOCK_UPDATE_RANDOM;
				}
			}
		}
		return false;
	}

	public function getRadiusGrass(){
		$grass = 0;
		$x = $this->x;
		$y = $this->y;
		$z = $this->z;
		$x0 = ++$x;
		$x2 = --$x;

		for($i = 0; $i < 9; ++$i){//x+1

			if($i < 3){//0,1,2
				$z0 = $z;
				$y0 = $y;
				for(++$y0;;){
					if($i == 0) ++$z0;
					if($i == 2) --$z0;

					$b = $this->level->getBlock(new Vector3($x0, $y0, $z0));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
			elseif($i > 2 and $i < 6){
				$z1 = $z;
				for(;;){
					if($i == 3) ++$z1;
					if($i == 5) --$z1;

					$b = $this->level->getBlock(new Vector3($x0, $y, $z1));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
			elseif($i > 5){
				$z2 = $z;
				$y2 = $y;
				for(--$y2;;){
					if($i == 6) ++$z2;
					if($i == 8) --$z2;

					$b = $this->level->getBlock(new Vector3($x0, $y2, $z2));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
		}

		for($i = 0; $i < 9; ++$i){//x

			if($i < 3){
				$z0 = $z;
				$y0 = $y;
				for(++$y0;;){
					if($i == 0) ++$z0;
					if($i == 2) --$z0;

					$b = $this->level->getBlock(new Vector3($x, $y0, $z0));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
			elseif($i > 2 and $i < 6){
				$z1 = $z;
				for(;;){
					if($i == 3) ++$z1;
					if($i == 5) --$z1;

					$b = $this->level->getBlock(new Vector3($x, $y, $z1));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
			elseif($i > 5){
				$z2 = $z;
				$y2 = $y;
				for(--$y2;;){
					if($i == 6) ++$z2;
					if($i == 8) --$z2;

					$b = $this->level->getBlock(new Vector3($x, $y2, $z2));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
		}

		for($i = 0, $x2 = --$x; $i < 9; ++$i){//x-1

			if($i < 3){
				$z0 = $z;
				$y0 = $y;
				for(++$y0;;){
					if($i == 0) ++$z0;
					if($i == 2) --$z0;

					$b = $this->level->getBlock(new Vector3($x2, $y0, $z0));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
			elseif($i > 2 and $i < 6){
				$z1 = $z;
				for(;;){
					if($i == 3) ++$z1;
					if($i == 5) --$z1;

					$b = $this->level->getBlock(new Vector3($x2, $y, $z1));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
			elseif($i > 5){
				$z2 = $z;
				$y2 = $y;
				for(--$y2;;){
					if($i == 6) ++$z2;
					if($i == 8) --$z2;

					$b = $this->level->getBlock(new Vector3($x2, $y2, $z2));
					if ($b->getID() === GRASS) ++$grass;
					break 1;
				}
			}
		}
		return $grass;
	}
}