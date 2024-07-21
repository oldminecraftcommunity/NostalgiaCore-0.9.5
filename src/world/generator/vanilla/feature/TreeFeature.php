<?php
class TreeFeature extends Feature
{
	public function place(Level $level, MTRandom $rand, $x, $y, $z){
		$nextInt = $rand->nextInt(3) + 4;
		$z2 = true;
		if($y < 1 || $y + $nextInt + 1 > 128) return false;
		for($i = $y; $i <= $y + 1 + $nextInt; ++$i){
			$i2 = ($i == $y) ? 0 : 1;
			if($i >= (($y + 1) + $nextInt) - 2) $i2 = 2;
			
			for($i3 = $x - $i2; $i3 <= $x + $i2 && $z2; ++$i3){
				for($i4 = $z - $i2; $i4 <= $z + $i2 && $z2; ++$i4){
					if($i >= 0 && $i < 128){
						$tileID = $level->level->getBlockID($i3, $i, $i4);
						if($tileID != 0 && $tileID != LEAVES){
							return;
						}
					}else{
						return;
					}
				}
			}
		}
		if($z2){
			$tileID = $level->level->getBlockID($x, $y - 1, $z);
			if(($tileID == GRASS || $tileID == DIRT) && $y < (128 - $nextInt) - 1){
				$level->level->setBlockID($x, $y - 1, $z, DIRT);
			}
			for($i5 = ($y - 3) + $nextInt; $i5 <= $y + $nextInt; ++$i5){
				$i6 = $i5 - ($y + $nextInt);
				$i7 = (int)(1 - ($i6 / 2));
				for($i8 = $x - $i7; $i8 <= $x + $i7; ++$i8){
					$i9 = $i8 - $x;
					for($i10 = $z - $i7; $i10 <= $z + $i7; ++$i10){
						$i11 = $i10 - $z;
						if((abs($i9) != $i7 || abs($i11) != $i7 || ($rand->nextInt(2) != 0 && $i6 != 0))/* && !Block.FULL_OPAQUE[world.getBlockIDAt(i8, i5, i10)]TODO opaque?*/) {
							$level->level->setBlockID($i8, $i5, $i10, LEAVES);
						}
					}
				}
			}
			for($i12 = 0; $i12 < $nextInt; ++$i12){
				$tileID = $level->level->getBlockID($x, $y + $i12, $z);
				if($tileID == 0 || $tileID == LEAVES){
					$level->level->setBlockID($x, $y + $i12, $z, WOOD);
				}
			}
		}
	}
}

