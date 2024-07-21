<?php

class PineFeature extends Feature
{
	public function place(Level $level, MTRandom $rand, $x, $y, $z){
		$l = $rand->nextInt(5) + 7;
		$i1 = $l - $rand->nextInt(2) - 3;
		$j1 = $l - $i1;
		$k1 = 1 + $rand->nextInt($j1 + 1);
		$flag = true;
		if($y < 1 || $y + $l + 1 > 128){
			return false;
		}
		for($l1 = $y; $l1 <= $y + 1 + $l && $flag; ++$l1){
			$j2 = 1;
			if($l1 - $y < $i1){
				$j2 = 0;
			}else{
				$j2 = $k1;
			}
			for($l2 = $x - $j2; $l2 <= $x + $j2 && $flag; ++$l2){
				for($k3 = $z - $j2; $k3 <= $z + $j2 && $flag; ++$k3){
					if($l1 >= 0 && $l1 < 128){
						$j4 = $level->level->getBlockID($l2, $l1, $k3);
						if($j4 != 0 && $j4 != LEAVES){
							return;
						}
					}else{
						return;
					}
				}
			}
		}
		if(!$flag) return false;
		
		$i2 = $level->level->getBlockID($x, $y - 1, $z);
		if(($i2 != GRASS && $i2 != DIRT) || $y >= 128 - $l - 1) return false;
		$level->level->setBlockID($x, $y - 1, $z, DIRT);
		$k2 = 0;
		for($i3 = $y + $l; $i3 >= $y + $i1; --$i3){
			for($l3 = $x - $k2; $l3 <= $x + $k2; ++$l3){
				$k4 = $l3 - $x;
				for($l4 = $z - $k2; $l4 <= $z + $k2; ++$l4){
					$i5 = $l4 - $z;
					if((abs($k4) != $k2 || abs($i5) != $k2 || $k2 <= 0)/* && !Block.opaqueCubeLookup[world.getBlockId(l3, i3, l4)] TODO opaque*/){
						$level->level->setBlock($l3, $i3, $l4, LEAVES, 1);
					}
				}
			}
			
			if($k2 >= 1 && $i3 == $y + $i1 + 1){
				--$k2;
				continue;
			}
			if($k2 < $k1){
				++$k2;
			}
		}
		
		for($j3 = 0; $j3 < $l - 1; ++$j3){
			$i4 = $level->level->getBlockID($x, $y + $j3, $z);
			if($i4 == 0 || $i4 == LEAVES){
				$level->level->setBlock($x, $y + $j3, $z, WOOD, 1);
			}
		}
	}
}

