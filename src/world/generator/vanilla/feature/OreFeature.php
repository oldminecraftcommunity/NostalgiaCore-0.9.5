<?php

class OreFeature
{
	public static function place(Level $level, MTRandom $rand, $x, $y, $z, $id, $amount){
		$nextFloat = $rand->nextFloat() * 3.1415927;
		
		$sin = ($x + 8 + ((sin($nextFloat) * $amount) / 8));
		$sin2 = (($x + 8) - ((sin($nextFloat) * $amount) / 8));
		
		$cos = ($z + 8 + ((cos($nextFloat) * $amount) / 8));
		$cos2 = (($z + 8) - ((cos($nextFloat) * $amount) / 8));
		
		$nextInt = $y + $rand->nextInt(3) + 2;
		$nextInt2 = $y + $rand->nextInt(3) + 2;
		for($i = 0; $i <= $amount; ++$i){
			$d = $sin + ((($sin2 - $sin) * $i) / $amount);
 			$d2 = $nextInt + ((($nextInt2 - $nextInt) * $i) / $amount);
 			$d3 = $cos + ((($cos2 - $cos) * $i) / $amount);
 			
 			$nextFloat = ($rand->nextFloat() * $amount) / 16;
 			$sin3 = (((sin(($i * 3.1415927) / $amount) + 1) * $nextFloat) + 1.0);
 			$sin4 = (((sin(($i * 3.1415927) / $amount) + 1) * $nextFloat) + 1.0);
 			
 			$floor = floor($d - ($sin3 / 2));
 			$floor2 = floor($d2 - ($sin4 / 2));
 			$floor3 = floor($d3 - ($sin3 / 2.0));
 			$floor4 = floor($d + ($sin3 / 2.0));
 			$floor5 = floor($d2 + ($sin4 / 2.0));
 			$floor6 = floor($d3 + ($sin3 / 2.0));
 			
 			for($i2 = $floor; $i2 <= $floor4; ++$i2){
 				$d4 = (($i2 + 0.5) - $d) / ($sin3 / 2);
 				$d4sqrd = $d4*$d4;
 				if($d4sqrd < 1){
 					for($i3 = $floor2; $i3 <= $floor5; ++$i3){
 						$d5 = (($i3 + 0.5) - $d2) / ($sin4 / 2);
 						$d5sqrd = $d5*$d5;
 						if($d4sqrd+$d5sqrd < 1){
 							for($i4 = $floor3; $i4 <= $floor6; ++$i4){
 								$d6 = (($i4 + 0.5) - $d3) / ($sin3 / 2);
 								if($d4sqrd+$d5sqrd+($d6*$d6) < 1 && $level->level->getBlockID($i2, $i3, $i4) == STONE){
 									$level->level->setBlockID($i2, $i3, $i4, $id);
 								}
 							}
 						}
 					}
 				}
 			}
		}
	}
}

