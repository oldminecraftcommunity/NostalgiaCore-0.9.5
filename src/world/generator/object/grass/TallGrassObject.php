<?php

class TallGrassObject{

	public static function growGrass(Level $level, Vector3 $pos, Random $random, $count = 15, $radius = 10){
		$arr = [
			BlockAPI::get(DANDELION, 0),
			BlockAPI::get(CYAN_FLOWER, 0),
			BlockAPI::get(TALL_GRASS, 1),
			BlockAPI::get(TALL_GRASS, 1),
			BlockAPI::get(TALL_GRASS, 2),
			BlockAPI::get(TALL_GRASS, 1)
		];
		$arrC = count($arr) - 1;
		for($c = 0; $c < $count; ++$c){
			$x = $random->nextRange($pos->x - $radius, $pos->x + $radius);
			$z = $random->nextRange($pos->z - $radius, $pos->z + $radius);
			for($y = $pos->y - 2; $y <= $pos->y + 2; ++$y){
				if($level->level->getBlockID($x, $y + 1, $z) === AIR and $level->level->getBlockID($x, $y, $z) === GRASS){
					$t = $arr[$random->nextRange(0, $arrC)];
					$level->setBlockRaw(new Vector3($x, $y + 1, $z), $t);
					break;
				}
			}
		}
	}
}