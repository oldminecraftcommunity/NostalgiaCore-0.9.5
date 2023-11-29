<?php
//b1.7.3
class CaveGenerator
{
	public $range = 8;
	public $rand;
	public $curChunkX, $curChunkZ;
	public function __construct($seed){
		$this->rand = new Random($seed);
	}
	
	public function generate(Level $level, $xCenter, $zCenter){
		$i = $this->range;
		$this->rand->setSeed($level->getSeed());
		$seedInt1 = ((int)($this->rand->nextInt() / 2) * 2) + 1;
		$seedInt2 = ((int)($this->rand->nextInt() / 2) * 2) + 1;
		
		for($x = $xCenter - $i; $x <= $xCenter + $i; ++$x){
			for($z = $zCenter - $i; $z <= $zCenter + $i; ++$z){
				$this->rand->setSeed((($x * $seedInt1) + ($z * $seedInt2)) ^ $level->getSeed());
				$this->generate2($level, $x, $z, $xCenter, $zCenter);
			}
		}
	}
	
	public function generate2(Level $level, $x, $z, $xCenter, $zCenter){
		$nextInt = $this->rand->nextInt($this->rand->nextInt($this->rand->nextInt(40) + 1) + 1);
		if($this->rand->nextInt(15) != 0){
			$nextInt = 0;
		}
		
		for($i = 0; $i < $nextInt; ++$i){
			$randX = ($x * 16) + $this->rand->nextInt(16);
			$randY = $this->rand->nextInt($this->rand->nextInt(120) + 8);
			$randZ = ($z * 16) + $this->rand->nextInt(16);
			
			$i2 = 1;
			if($this->rand->nextInt(4) == 0){
				$this->generate3($level, $xCenter, $zCenter, $randX, $randY, $randZ);
				$i2 = 1 + $this->rand->nextInt(4);
			}
			
			for($i3 = 0; $i3 < $i2; ++$i3){
				//generate(xCenter, zCenter, tileIdArray, randX, randY, randZ, (this.rand.nextFloat() * 2.0f) + this.rand.nextFloat(), this.rand.nextFloat() * 3.1415927f * 2.0f, ((this.rand.nextFloat() - 0.5f) * 2.0f) / 8.0f, 0, 0, 1.0d);
				$this->generate4($level, $xCenter, $zCenter, $randX, $randY, $randZ, ($this->rand->nextFloat() * 2) + $this->rand->nextFloat(), $this->rand->nextFloat() * M_PI * 2, (($this->rand->nextFloat() - 0.5) * 2) / 8, 0, 0, 1);
			}
		}
	}
	
	public function generate3(Level $level, $xCenter, $zCenter, $x, $y, $z){
		//generate(xCenter, zCenter, tileIdArray, x, y, z, 1.0f + (this.rand.nextFloat() * 6.0f), 0.0f, 0.0f, -1, -1, 0.5d); gen4
		$this->generate4($level, $xCenter, $zCenter, $x, $y, $z, 1 + ($this->rand->nextFloat() * 6), 0, 0, -1, -1, 0.5);
	}
	
	public function generate4(Level $level, $xCenter, $zCenter, $x, $y, $z, $randFloat, $f1, $f2, $k, $i1, $d3){
		$d = $xCenter*16 + 8;
		$d2 = $zCenter*16 + 8;
		$f = $f3 = 0;
		$random = new Random($this->rand->nextInt());
		
		if($i1 <= 0){
			$i = ($this->range * 16) - 16;
			$i1 = $i - $random->nextInt((int)($i / 4));
		}
		$z2 = false;
		if($k == -1){
			$k = $i1 / 2;
			$z2 = true;
		}
		
		$nextInt = $random->nextInt((int)($i1 / 2));
		$z3 = $random->nextInt(6) == 0;
		while($k < $i1){
			$sin = 1.5 + (sin(($k * M_PI) / $i1) * $randFloat * 1);
			$d4 = $sin * $d3;
			$cos = cos($f2);
			$x += cos($f1) * $cos;
			$y += sin($f2);
			$z += sin($f1) * $cos;
			
			$f22 = $z3 ? ($f2 * 0.92) : ($f2 * 0.7);
			$f2 = $f22 + ($f3 * 0.1);
			$f1 += $f * 0.1;
			$f3 = ($f3 * 0.9) + (($random->nextFloat() - $random->nextFloat()) * $random->nextFloat() * 2);
			$f = ($f * 0.75) + (($random->nextFloat() - $random->nextFloat()) * $random->nextFloat() * 4);
			if(!$z2 && $k == $nextInt && $randFloat > 1){
				$this->generate4($level, $xCenter, $zCenter, $x, $y, $z, ($random->nextFloat() * 0.5) + 0.5, $f1 - M_PI_2, $f2 / 3, $k, $i1, 1);
				$this->generate4($level, $xCenter, $zCenter, $x, $y, $z, ($random->nextFloat() * 0.5) + 0.5, $f1 + M_PI_2, $f2 / 3, $k, $i1, 1);
				return;
			}
			if($z2 || $random->nextInt(4) != 0){
				$d5 = $x - $d;
				$d6 = $z - $d2;
				$d7 = $i1 - $k;
				$d8 = $randFloat + 2 + 16;
				if((($d5 * $d5) + ($d6*$d6) - ($d7*$d7)) > $d8*$d8){
					return;
				}
				
				if($x >= (($d - 16) - ($sin * 2)) && $z >= (($d2 - 16) - ($sin * 2)) && $x <= ($d + 16 + ($sin * 2)) && $z <= ($d2 + 16 + ($sin * 2))){
					$floor = (floor($x - $sin) - ($xCenter * 16)) - 1;
					$floor2 = (floor($x + $sin) - ($xCenter * 16)) + 1;
					$floor3 = floor($y - $d4) - 1;
					$floor4 = floor($y + $d4) + 1;
					$floor5 = (floor($z - $sin) - ($zCenter * 16)) - 1;
					$floor6 = (floor($z + $sin) - ($zCenter * 16)) + 1;
					
					if($floor < 0) $floor = 0;
					if($floor2 > 16) $floor2 = 16;
					if($floor3 < 1) $floor3 = 1;
					if($floor4 > 120) $floor4 = 120;
					if($floor5 < 0) $floor5 = 0;
					if($floor6 > 16) $floor6 = 16;
					
					$z4 = false;
					for($i2 = $floor; !$z4 && $i2 < $floor2; ++$i2){ //x
						for($i3 = $floor5; !$z4 && $i3 < $floor6; ++$i3){ //z
							$i4 = $floor4 + 1; //y
							while(!$z4 && $i4 >= ($floor3 - 1)){
								if($i4 >= 0 && $i4 < 128){
									$id = $level->level->getBlockID($this->curChunkX*16 + $x, $y, $this->curChunkZ*16 + $z);
									$z4 = $id == WATER || $id == STILL_WATER;
									if($i4 != $floor3 - 1 && $i2 != $floor && $i2 != $floor2 - 1 && $i3 != $floor5 && $i3 != $floor6 - 1){
										$i4 = $floor3;
									}
								}
								--$i4;
							}
						}
					}
					if($z4){
						continue;
					}else{
						for($i6 = $floor; $i6 < $floor2; ++$i6){ //x
							$d9 = ((($i6 + ($xCenter * 16)) + 0.5) - $x) / $sin;
							for($i7 = $floor5; $i7 < $floor6; ++$i7){ //z
								$d10 = ((($i7 + ($zCenter * 16)) + 0.5) - $z) / $sin;
								$i8 = ((($i6 * $i6) + $i7) * 128) + $floor4;
								$z5 = false;
								if(($d9 * $d9) + ($d10 * $d10) < 1){
									for($i9 = $floor4 - 1; $i9 >= $floor3; --$i9){
										$d11 = (($i9 + 0.5) - $y) / $d4;
										if($d11 > -0.7 && ($d9*$d9)+($d11*$d11)+($d10*$d10) < 1){
											$b = $level->level->getBlockID($this->curChunkX*16 + $i6, $floor4, $this->curChunkZ*16 + $i7);
											if($b == GRASS) $z5 = true;
											if($b == STONE || $b == DIRT || $b == GRASS){
												if($i9 < 10){
													$level->level->setBlockID($this->curChunkX*16 + $i6, $floor4, $this->curChunkZ*16 + $i7, LAVA);
												}else{
													//ConsoleAPI::info("place air at ".($this->curChunkX*16 + $i6).":$floor4:".($this->curChunkZ*16 + $i7));
													$level->level->setBlockID($this->curChunkX*16 + $i6, $floor4, $this->curChunkZ*16 + $i7, 0, true);
													
													if($z5){
														$belowID = $level->level->getBlockID($this->curChunkX*16 + $i6, $floor4 - 1, $this->curChunkZ*16 + $i7);
														if($belowID == DIRT){
															ConsoleAPI::info("place grass at ".($this->curChunkX*16 + $i6).":$floor4:".($this->curChunkZ*16 + $i7));
															$level->level->setBlockID($this->curChunkX*16 + $i6, $floor4 - 1, $this->curChunkZ*16 + $i7, GRASS);
														}
													}
												}
											}
										}
										--$i8;
									}
									
								}
							}
						}
						if($z2) return;
					}
				}
			}
		}
		
	}
}

