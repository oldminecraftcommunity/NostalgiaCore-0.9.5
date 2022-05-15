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

/***REM_START***/
require_once("TreeObject.php");
/***REM_END***/

class SmallTreeObject extends TreeObject{
	public $type = 0;
	private $trunkHeight = 5;
	private static $leavesHeight = 4; // All trees appear to be 4 tall
	private static $leafRadii = array( 1, 1.41, 2.83, 2.24 );
	public $treeHeight = 7;
	private $addLeavesVines = false;
	private $addLogVines = false;
	private $addCocoaPlants = false;

	public function canPlaceObject(Level $level, Vector3 $pos, Random $random){
		$radiusToCheck = 0;
		for ($yy = 0; $yy < $this->trunkHeight + 3; ++$yy) {
			if($yy == 1 or $yy === $this->trunkHeight) {
				++$radiusToCheck;
			}
			for($xx = -$radiusToCheck; $xx < ($radiusToCheck + 1); ++$xx){
				for($zz = -$radiusToCheck; $zz < ($radiusToCheck + 1); ++$zz){
					if(!isset($this->overridable[$level->level->getBlockID($pos->x + $xx, $pos->y + $yy, $pos->z + $zz)])){
						return false;
					}
				}
			}
		}
		return true;
	}
	
	protected function placeTrunk(Level $level, $x, $y, $z, Random $random, $trunkHeight){
		// The base dirt block
		$dirtpos = new Vector3($x, $y - 1, $z);
		$level->setBlockRaw($dirtpos, new DirtBlock());

		for($yy = 0; $yy < $trunkHeight; ++$yy){
			$blockId = $level->getBlock(new Vector3($x, $y + $yy, $z))->getID();
			if(isset($this->overridable[$blockId])){
				$trunkpos = new Vector3($x, $y + $yy, $z);
				$level->setBlockRaw($trunkpos, new WoodBlock($this->type));
			}
		}
	}
	
	public function placeObject(Level $level, Vector3 $pos, Random $random){
		$this->treeHeight = mt_rand(0, 3) + 4; //randomized tree height
		$x = $pos->getX();
		$y = $pos->getY();
		$z = $pos->getZ();
		$this->placeTrunk($level, $x, $y, $z, $random, $this->treeHeight - 1);

		for($yy = $y - 3 + $this->treeHeight; $yy <= $y + $this->treeHeight; ++$yy){
			$yOff = $yy - ($y + $this->treeHeight);
			$mid = (int) (1 - $yOff / 2);
			for($xx = $x - $mid; $xx <= $x + $mid; ++$xx){
				$xOff = abs($xx - $x);
				for($zz = $z - $mid; $zz <= $z + $mid; ++$zz){
					$zOff = abs($zz - $z);
					if($xOff === $mid and $zOff === $mid and ($yOff === 0 or mt_rand(0, 2) === 0)){
						continue;
					}
					if(!$level->getBlock(new Vector3($x, $y + $yy, $z))->isSolid){
						$leafpos = new Vector3($xx, $yy, $zz);
						$level->setBlockRaw($leafpos, new LeavesBlock($this->type));
					}
				}
			}
		}
	}
	
}