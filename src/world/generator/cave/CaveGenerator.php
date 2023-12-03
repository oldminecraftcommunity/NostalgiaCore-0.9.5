<?php
//b1.7.3
class CaveGenerator extends StructureBase
{
	
	public function recursiveGenerate(Level $level, $chunkXoffsetted, $chunkZoffsetted, $chunkX, $chunkZ){
		$nextInt = $this->rand->nextInt($this->rand->nextInt($this->rand->nextInt(40) + 1) + 1);
		if($this->rand->nextInt(15) != 0){
			$nextInt = 0;
		}
		
		for($i = 0; $i < $nextInt; ++$i){
			$randX = ($chunkXoffsetted * 16) + $this->rand->nextInt(16);
			$randY = $this->rand->nextInt($this->rand->nextInt(120) + 8);
			$randZ = ($chunkZoffsetted * 16) + $this->rand->nextInt(16);
			
			$i2 = 1;
			if($this->rand->nextInt(4) == 0){
				$this->generateLargeCaveNode($level, $chunkX, $chunkZ, $randX, $randY, $randZ);
				$i2 = 1 + $this->rand->nextInt(4);
			}
			
			for($i3 = 0; $i3 < $i2; ++$i3){
				
				$v17 = $this->rand->nextFloat() * M_PI * 2;
				$v18 = ($this->rand->nextFloat() - 0.5) * 2 / 8;
				$v19 = $this->rand->nextFloat() * 2 + $this->rand->nextFloat();
				if($this->rand->nextInt(10) == 0) {
					$v19 *= $this->rand->nextFloat() * $this->rand->nextFloat() * 3 + 1;
				}
				
				
				$this->generateCaveNode($level, $chunkX, $chunkZ, $randX, $randY, $randZ, $v19, $v17, $v18, 0, 0, 1);
			}
		}
	}
	
	public function generateLargeCaveNode(Level $level, $xCenter, $zCenter, $x, $y, $z){
		$this->generateCaveNode($level, $xCenter, $zCenter, $x, $y, $z, 1 + ($this->rand->nextFloat() * 6), 0, 0, -1, -1, 0.5);
	}
	
	public function generateCaveNode(Level $level, $chunkX, $chunkZ, $x, $y, $z, $randFloat, $f1, $f2, $unk_1, $unk_2, $d3){
		$chunkCenterX = $chunkX*16 + 8;
		$chunkCenterZ = $chunkZ*16 + 8;
		$f = $f3 = 0;
		$random = new MTRandom($this->rand->nextInt());
		
		if($unk_2 <= 0){
			$i = ($this->range * 16) - 16;
			$unk_2 = $i - $random->nextInt((int)($i / 4));
		}
		$z2 = false;
		if($unk_1 == -1){
			$unk_1 = (int)($unk_2 / 2);
			$z2 = true;
		}
		
		$var27 = $random->nextInt((int)($unk_2 / 2)) + ($unk_2 / 4);
		for($var28 = ($random->nextInt(6) == 0); $unk_1 < $unk_2; ++$unk_1){
			$horizontalDiff = 1.5 + sin($unk_1 * M_PI / $unk_2) * $randFloat /* * 1 */;
			$verticalDiff = $horizontalDiff * $d3;
			$var33 = cos($f2);
			$var34 = sin($f2);
			$x += cos($f1) * $var33;
			$y += $var34;
			$z += sin($f1) * $var33;
			
			$f2 = $var28 ? ($f2 * 0.92) : ($f2 * 0.7);
			
			$f2 += $f3 * 0.1;
			$f1 += $f * 0.1;
			
			$f3 *= 0.9;
			$f *= 0.75;
			$f3 += ($random->nextFloat() - $random->nextFloat()) * $random->nextFloat() * 2;
			$f += ($random->nextFloat() - $random->nextFloat()) * $random->nextFloat() * 2;
			
			if(!$z2 && $unk_1 == $var27 && $randFloat > 1 && $unk_2 > 0){
				//this.generateCaveNode(random.nextLong(), chunkX, chunkZ, par5ArrayOfByte, x, y, z, random.nextFloat() * 0.5F + 0.5F, f1 - ((float)Math.PI / 2F), f2 / 3.0F, unk_1, unk_2, 1.0D);
				//this.generateCaveNode(random.nextLong(), chunkX, chunkZ, par5ArrayOfByte, x, y, z, random.nextFloat() * 0.5F + 0.5F, f1 + ((float)Math.PI / 2F), f2 / 3.0F, unk_1, unk_2, 1.0D);
				$this->generateCaveNode($level, $chunkX, $chunkZ, $x, $y, $z, $random->nextFloat() * 0.5 + 0.5, $f1 - (M_PI / 2), $f2 / 3, $unk_1, $unk_2, 1);
				$this->generateCaveNode($level, $chunkX, $chunkZ, $x, $y, $z, $random->nextFloat() * 0.5 + 0.5, $f1 + (M_PI / 2), $f2 / 3, $unk_1, $unk_2, 1);
				return;
			}
			
			if($z2 || $random->nextInt(4) != 0){
				$distFromCenterX = $x - $chunkCenterX;
				$distFromCenterZ = $z - $chunkCenterZ;
				
				$var39 = ($unk_2 - $unk_1);
				$var41 = $randFloat + /*2 + 16*/ 18;
				
				if($distFromCenterX*$distFromCenterX + $distFromCenterZ*$distFromCenterZ - $var39*$var39 > $var41*$var41){
					return;
				}
				//if (x >= chunkCenterX - 16.0D - var29 * 2.0D && z >= chunkCenterZ - 16.0D - var29 * 2.0D && x <= chunkCenterX + 16.0D + var29 * 2.0D && z <= chunkCenterZ + 16.0D + var29 * 2.0D)
				if($x >= $chunkCenterX - 16 - $horizontalDiff*2 && $z >= $chunkCenterZ - 16 - $horizontalDiff*2 && $x <= $chunkCenterX + 16 + $horizontalDiff*2 && $z <= $chunkCenterZ + 16 + $horizontalDiff*2){
					$minX = floor($x - $horizontalDiff) - $chunkX*16 - 1;
					$maxX = floor($x + $horizontalDiff) - $chunkX*16 + 1;
					$minY = floor($y - $verticalDiff) - 1;
					$maxY = floor($y + $verticalDiff) + 1;
					$minZ = floor($z - $horizontalDiff) - $chunkZ*16 - 1;
					$maxZ = floor($z + $horizontalDiff) - $chunkZ*16 + 1;
					
					if($minX < 0) $minX = 0;
					if($maxX > 16) $maxX = 16;
					
					if($minY < 1) $minY = 1;
					if($maxY > 120) $maxY = 120;
					
					if($minZ < 0) $minZ = 0;
					if($maxZ > 16) $maxZ = 16;
					
					$hasWater = false;
					for($blockX = $minX; !$hasWater && $blockX < $maxX; ++$blockX){
						for($blockZ = $minZ; !$hasWater && $blockZ < $maxZ; ++$blockZ){
							for($blockY = $maxY + 1; !$hasWater && $blockY >= $minY - 1; --$blockY){
								if($blockY >= 0 && $blockY < 128){
									$id = $level->level->getBlockID($blockX + $chunkX*16, $blockY, $blockZ + $chunkZ * 16);
									$hasWater = $id == WATER || $id == STILL_WATER;
									//if (blockY != minY - 1 && blockX != minX && blockX != maxX - 1 && blockZ != minZ && blockZ != maxZ - 1)
									if($blockY != $minY - 1 && $blockX != $minX && $blockX != $maxX - 1 && $blockZ != $minZ && $blockZ != $maxZ - 1){
										$blockY = $minY;
									}
								}
							}
						}
					}
					
					if(!$hasWater){
						for($blockX = $minX; $blockX < $maxX; ++$blockX){
							$var59 = (($blockX + $chunkX*16) + 0.5 - $x) / $horizontalDiff;
							for($blockZ = $minZ; $blockZ < $maxZ; ++$blockZ){
								$var46 = (($blockZ + $chunkZ*16) + 0.5 - $z) / $horizontalDiff;
								$yPosition = $maxY;
								$hasGrass = false;
								
								if($var59*$var59 + $var46*$var46 < 1){
									for($blockY = $maxY - 1; $blockY >= $minY; --$blockY){
										$var51 = ($blockY + 0.5 - $y) / $verticalDiff;
										if($var51 > -0.7 && $var59*$var59 + $var51*$var51 + $var46*$var46 < 1){
											$blockID = $level->level->getBlockID($blockX + $chunkX*16, $yPosition, $blockZ + $chunkZ * 16);
											$hasGrass = $blockID == GRASS;
											if($blockID == STONE || $blockID == DIRT || $hasGrass){
												if($blockY < 10){
													$level->level->setBlockID($blockX + $chunkX*16, $yPosition, $blockZ + $chunkZ * 16, LAVA);
												}else{
													$level->level->setBlockID($blockX + $chunkX*16, $yPosition, $blockZ + $chunkZ * 16, 0);
													if($hasGrass && $level->level->getBlockID($blockX + $chunkX*16, $yPosition - 1, $blockZ + $chunkZ * 16) == DIRT){
														//ConsoleAPI::debug("place grass at ".($blockX + $chunkX*16).":".($yPosition - 1).":".($blockZ + $chunkZ * 16));
														$level->level->setBlockID($blockX + $chunkX*16, $yPosition - 1, $blockZ + $chunkZ * 16, GRASS);
													}
												}
											}
										}
										--$yPosition;
									}
								}
							}
						}
					}
				}
			}
		}
	}
}

