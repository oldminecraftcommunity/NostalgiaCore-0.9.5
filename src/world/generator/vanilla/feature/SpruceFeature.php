<?php
class SpruceFeature extends Feature
{
	public function place(Level $level, MTRandom $rand, $x, $y, $z){
		$nextInt = $rand->nextInt(4) + 6;
		$nextInt2 = 1 + $rand->nextInt(2);
		$i2 = $nextInt - $nextInt2;
		$nextInt3 = 2 + $rand->nextInt(2);
		$z2 = true;
		if($y < 1 || $y + $nextInt + 1 > 128){
			return false;
		}
		
		for($i3 = $y; $i3 <= $y + 1 + $nextInt && $z2; ++$i3){
			if($i3 - $y < $nextInt2){
				$i = 0;
			}else{
				$i = $nextInt3;
			}
			for($i4 = $x - $i; $i4 <= $x + $i && $z2; ++$i4){
				for($i5 = $z - $i; $i5 <= $z + $i && $z2; ++$i5){
					if($i3 >= 0 && $i3 < 128){
						$blockID = $level->level->getBlockID($i4, $i3, $i5);
						if($blockID != 0 && $blockID != LEAVES){
							$z2 = false;
						}
					}else{
						$z2 = false;
					}
				}
			}
		}
		
		if($z2){
			$blockID = $level->level->getBlockID($x, $y - 1, $z);
			if(($blockID == GRASS || $blockID == DIRT) && $y < (128 - $nextInt) - 1){
				$level->level->setBlock($x, $y - 1, $z, DIRT);
				$nextInt4 = $rand->nextInt(2);
				$i6 = 1;
				$i7 = 0;
				for($i8 = 0; $i8 <= $i2; ++$i8){
					$i9 = ($y + $nextInt) - $i8;
					for($i10 = $x - $nextInt4; $i10 <= $x + $nextInt4; ++$i10){
						$i11 = $i10 - $x;
						for($i12 = $z - $nextInt4; $i12 <= $z + $nextInt4; ++$i12){
							$i13 = $i12 - $z;
							if((abs($i11) != $nextInt4 || abs($i13) != $nextInt4 || $nextInt4 <= 0)/* && !Block.FULL_OPAQUE[world.getBlockIDAt(i10, i9, i12)]TODO opaque*/) {
								$level->level->setBlock($i10, $i9, $i12, LEAVES, 1);
							}
						}
					}
					
					if($nextInt4 >= $i6){
						$nextInt4 = $i7;
						$i7 = 1;
						if(++$i6 > $nextInt3){
							$i6 = $nextInt3;
						}
					}else{
						++$nextInt4;
					}
				}
				$nextInt5 = $rand->nextInt(3);
				for($i14 = 0; $i14 < $nextInt - $nextInt5; ++$i14){
					$blockID = $level->level->getBlockID($x, $y + $i14, $z);
					if($blockID == 0 || $blockID == LEAVES){
						$level->level->setBlock($x, $y + $i14, $z, WOOD, 1);
					}
				}
				return true;
			}
			return false;
		}
		return false;
	}
}

