<?php

/***REM_START***/
require_once("NoiseGenerator.php");
/***REM_END***/

class NoiseGeneratorOctaves extends NoiseGenerator{
	public $octaves;
	private $generatorCollection;
	public function __construct(MTRandom $random, $octaves){	
		$this->generatorCollection = array();
		$this->octaves = (int) $octaves;
		for($o = 0; $o < $this->octaves; ++$o){
			$this->generatorCollection[$o] = new NoiseGeneratorPerlin($random);
		}
	}
	
	public function getValue($x, $y){
		$noise = 0;
		$scale = 1;
		for($i = 0; $i < $this->octaves; ++$i){
			$noise += $this->generatorCollection[$i]->getValue($x * $scale, $y * $scale) / $scale;
			$scale /= 2;
		}
		return $noise;
	}
	
	public function generateNoiseOctaves($int1, $int2, $int3, $int4, $int5, $int6, $par1 = false, $par2 = false, $par3 = false){
		if($par1 === false or $par2 === false or $par3 === false){
			return $this->generateNoiseOctaves($int1, 10, $int2, $int3, 1, $int4, $int5, 1, $int6);
		}
		
		$floats = array_fill(0, $int4 * $int5 * $int6, 0);
		$d1 = 1;
		
		for($j = 0; $j < $this->octaves; ++$j){
			$d2 = $int1 * $d1 * $par1;
			$d3 = $int2 * $d1 * $par2;
			$d4 = $int3 * $d1 * $par3;
			$l1 = floor($d2);
			$l2 = floor($d4);
			$d2 -= $l1;
			$d4 -= $l2;
			$l1 %= 16777216;
			$l2 %= 16777216;
			
			$d2 += $l1;
			$d4 += $l2;
			$this->generatorCollection[$j]->populateNoiseArray($floats, $d2, $d3, $d4, $int4, $int5, $int6, $par1 * $d1, $par2 * $d1, $par3 * $d1, $d1);
			$d1 /= 2;
		}
		return $floats;
	}
}