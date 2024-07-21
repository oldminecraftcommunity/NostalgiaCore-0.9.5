<?php
class ClayFeature
{
	public static function place(Level $level, MTRandom $rand, $x, $y, $z){
		$size = 32;
		$clayid = CLAY_BLOCK;
		$id = $level->level->getBlockID($x, $y, $z);
		if($id != WATER && $id != STILL_WATER) return false;
		
		$nextFloat = $rand->nextFloat() * 3.1416;
		$sin = (float)($x + 8 + ((sin($nextFloat) * $size) / 8));
		$sin2 = (float)(($x + 8) - ((sin($nextFloat) * $size) / 8));
		$cos = (float)($z + 8 + ((cos($nextFloat) * $size) / 8));
		$cos2 = (float)(($z + 8) - ((cos($nextFloat) * $size) / 8));
		
		$nextInt = $y + $rand->nextInt(3) + 2;
		$nextInt2 = $y + $rand->nextInt(3) + 2;
		
		for($i = 0; $i <= $size; ++$i){
			$d = $sin + ((($sin2 - $sin) * $i) / $size);
			$d2 = $nextInt + ((($nextInt2 - $nextInt) * $i) / $size);
			$d3 = $cos + ((($cos2 - $cos) * $i) / $size);
			
			$nextFloat = ($rand->nextFloat() * $size) / 16;
			$sin3 = (((sin(($i * 3.1416) / $size) + 1) * $nextFloat) + 1);
			$sin4 = (((sin(($i * 3.1416) / $size) + 1) * $nextFloat) + 1);//TODO optimize a bit?
			$floor = floor($d - ($sin3 / 2));
			$floor2 = floor($d + ($sin3 / 2));
			$floor3 = floor($d2 - ($sin4 / 2.0));
			$floor4 = floor($d2 + ($sin4 / 2.0));
			$floor5 = floor($d3 - ($sin3 / 2.0));
			$floor6 = floor($d3 + ($sin3 / 2.0));
			
			for($i2 = $floor; $i2 <= $floor2; ++$i2){
				for($i3 = $floor3; $i3 <= $floor4; ++$i3){
					for($i4 = $floor5; $i4 <= $floor6; ++$i4){
						$d4 = (($i2 + 0.5) - $d) / ($sin3 / 2);
						$d5 = (($i3 + 0.5) - $d2) / ($sin4 / 2);
						$d6 = (($i4 + 0.5) - $d3) / ($sin3 / 2);
						if(($d4*$d4)+($d5*$d5)+($d6*$d6)<1 && $level->level->getBlockID($i2, $i3, $i4) == SAND){
							$level->level->setBlockID($i2, $i3, $i4, $clayid);
							console("Placed clay at".$i2.":".$i4);
						}
					}
				}
			}
		}
		
	}
}

