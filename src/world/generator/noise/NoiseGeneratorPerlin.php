<?php

/***REM_START***/
require_once("NoiseGenerator.php");

/***REM_END***/
class NoiseGeneratorPerlin extends NoiseGenerator{

	public $xCoord, $yCoord, $zCoord;
	private $permutations = [];

	public function __construct(MTRandom $random){
		$this->xCoord = $random->nextFloat() * 256;
		$this->yCoord = $random->nextFloat() * 256;
		$this->zCoord = $random->nextFloat() * 256;

		for($i = 0; $i < 512; ++$i){
			$this->permutations[$i] = $i < 256 ? $i : 0;
		}

		for($i = 0; $i < 256; ++$i){
			$j = $random->nextInt(256 - $i) + $i;
			$k = $this->permutations[$i];
			$this->permutations[$i] = $this->permutations[$j];
			$this->permutations[$j] = $k;
			$this->permutations[$i + 256] = $this->permutations[$i];
		}

	}
	
	public function getValue($d, $d1, $d2 = 0){
		$d3 = $d + $this->xCoord;
		$d4 = $d1 + $this->yCoord;
		$d5 = $d2 + $this->zCoord;
		$i = floor($d3);
		$j = floor($d4);
		$k = floor($d5);
		$l = $i & 0xff;
		$i1 = $j & 0xff;
		$j1 = $k & 0xff;
		$d3 -= $i;
		$d4 -= $j;
		$d5 -= $k;
		$d6 = $d3 * $d3 * $d3 * ($d3 * ($d3 * 6 - 15) + 10);
		$d7 = $d4 * $d4 * $d4 * ($d4 * ($d4 * 6 - 15) + 10);
		$d8 = $d5 * $d5 * $d5 * ($d5 * ($d5 * 6 - 15) + 10);
		
		$k1 = (int) ($this->permutations[$l] + $i1);
		$l1 = (int) ($this->permutations[$k1] + $j1);
		$i2 = (int) ($this->permutations[$k1 + 1] + $j1);
		$j2 = (int) ($this->permutations[$l + 1] + $i1);
		$k2 = (int) ($this->permutations[$j2] + $j1);
		$l2 = (int) ($this->permutations[$j2 + 1] + $j1);
		
		return self::curve($d8,
			self::curve($d7,
				self::curve($d6, self::grad3D($this->permutations[$l1], $d3, $d4, $d5), self::grad3D($this->permutations[$k2], $d3 - 1, $d4, $d5)),
				self::curve($d6, self::grad3D($this->permutations[$i2], $d3, $d4 - 1, $d5), self::grad3D($this->permutations[$l2], $d3 - 1, $d4 - 1, $d5))
			),
			self::curve($d7,
				self::curve($d6, self::grad3D($this->permutations[$l1 + 1], $d3, $d4, $d5 - 1), self::grad3D($this->permutations[$k2 + 1], $d3 - 1, $d4, $d5 - 1)),
				self::curve($d6, self::grad3D($this->permutations[$i2 + 1], $d3, $d4 - 1, $d5 - 1), self::grad3D($this->permutations[$l2 + 1], $d3 - 1, $d4 - 1, $d5 - 1))
			)
		);
	}
	
	public function populateNoiseArray(&$floats, $par1, $par2, $par3, $int1, $int2, $int3, $par4, $par5, $par6, $par7){
		if($int2 === 1){
			$n = 0;
			$d3 = 1 / $par7;
			for($i1 = 0; $i1 < $int1; ++$i1){
				$d4 = $par1 + $i1 * $par4 + $this->xCoord;
				$i2 = floor($d4);
				$i3 = $i2 & 0xFF;
				$d4 -= $i2;
				$d5 = $d4 * $d4 * $d4 * ($d4 * ($d4 * 6 - 15) + 10);

				for($i4 = 0; $i4 < $int3; ++$i4){
					$d6 = $par3 + $i4 * $par6 + $this->zCoord;
					$i5 = floor($d6);
					$i6 = $i5 & 0xFF;
					$d6 -= $i5;
					$d7 = $d6 * $d6 * $d6 * ($d6 * ($d6 * 6 - 15) + 10);

					$i = $this->permutations[$i3];
					$j = $this->permutations[$i] + $i6;
					$k = $this->permutations[$i3 + 1];
					$m = $this->permutations[$k] + $i6;
					$d1 = self::curve($d5, self::grad2D($this->permutations[$j], $d4, $d6), self::grad3D($this->permutations[$m], $d4 - 1, 0, $d6));
					$d2 = self::curve($d5, self::grad3D($this->permutations[$j + 1], $d4, 0, $d6 - 1), self::grad3D($this->permutations[$m + 1], $d4 - 1, 0, $d6 - 1));

					$d8 = self::curve($d7, $d1, $d2);
					$floats[$n++] += $d8 * $d3;
				}
			}
			return;
		}

		$d9 = 1 / $par7;
		$m = -1;
		$n = 0;
		$i = 0;

		for($i4 = 0; $i4 < $int1; ++$i4){
			$d6 = $par1 + $i4 * $par4 + $this->xCoord;
			$i5 = floor($d6);
			$i6 = $i5 & 0xFF;
			$d6 -= $i5;
			$d7 = $d6 * $d6 * $d6 * ($d6 * ($d6 * 6 - 15) + 10);

			for($i12 = 0; $i12 < $int3; ++$i12){
				$d12 = $par3 + $i12 * $par6 + $this->zCoord;
				$i13 = floor($d12);
				$i14 = $i13 & 0xFF;
				$d12 -= $i13;
				$d13 = $d12 * $d12 * $d12 * ($d12 * ($d12 * 6 - 15) + 10);

				for($i15 = 0; $i15 < $int2; ++$i15){
					$d14 = $par2 + $i15 * $par5 + $this->yCoord;
					$i16 = floor($d14);
					$i17 = $i16 & 0xff;
					$d14 -= $i16;
					$d15 = $d14 * $d14 * $d14 * ($d14 * ($d14 * 6 - 15) + 10);

					if($i15 == 0 or $i17 != $m){
						$m = $i17;
						$i7 = $this->permutations[$i6] + $i17;
						$i8 = $this->permutations[$i7] + $i14;
						$i9 = $this->permutations[$i7 + 1] + $i14;
						$i10 = $this->permutations[$i6 + 1] + $i17;
						$n = $this->permutations[$i10] + $i14;
						$i11 = $this->permutations[$i10 + 1] + $i14;
						$d10 = self::curve($d7, self::grad3D($this->permutations[$i8], $d6, $d14, $d12), self::grad3D($this->permutations[$n], $d6 - 1, $d14, $d12));
						$d4 = self::curve($d7, self::grad3D($this->permutations[$i9], $d6, $d14 - 1, $d12), self::grad3D($this->permutations[$i11], $d6 - 1, $d14 - 1, $d12));
						$d11 = self::curve($d7, self::grad3D($this->permutations[$i8 + 1], $d6, $d14, $d12 - 1), self::grad3D($this->permutations[$n + 1], $d6 - 1, $d14, $d12 - 1));
						$d5 = self::curve($d7, self::grad3D($this->permutations[$i9 + 1], $d6, $d14 - 1, $d12 - 1), self::grad3D($this->permutations[$i11 + 1], $d6 - 1, $d14 - 1, $d12 - 1));
					}

					$d16 = $d10 + $d15 * ($d4 - $d10);
					$d17 = $d11 + $d15 * ($d5 - $d11);
					$d18 = $d16 + $d13 * ($d17 - $d16);
					$floats[$i++] += $d18 * $d9;
				}
			}
		}
	}

	public static final function curve($par1, $par2, $par3){
		return $par2 + $par1 * ($par3 - $par2);
	}

	public static function grad2D($int, $par1, $par2){
		$i = $int & 0x0F;
		$d1 = (1 - (($i & 0x08) >> 3)) * $par1;
		$d2 = ($i == 12 || $i == 14) ? $par1 : (($i >= 4)*$par2);
		return (($i & 0x01) ? -$d1 : $d1) + (($i & 0x02) ? -$d2 : $d2);
	}

	public static function grad3D($int, $par1, $par2, $par3){
		$i = $int & 0x0F;
		$d1 = $i < 8 ? $par1 : $par2;
		$d2 = ($i == 12 or $i == 14) ? $par1 : ($i < 4 ? $par2 : $par3);

		return (($i & 0x01) ? -$d1 : $d1) + (($i & 0x02) ? -$d2 : $d2);
	}
}