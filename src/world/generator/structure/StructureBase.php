<?php

abstract class StructureBase
{
	public $range = 8;
	public $rand;
	
	public function __construct(){
		$this->rand = new MTRandom();
	}
	
	public function generate(Level $level, $chunkX, $chunkZ){
		$range = $this->range;
		$this->rand->setSeed($level->getSeed());
		$seedInt1 = $this->rand->nextInt();
		$seedInt2 = $this->rand->nextInt();
		
		for($x = $chunkX - $range; $x <= $chunkX + $range; ++$x){
			for($z = $chunkZ - $range; $z <= $chunkZ + $range; ++$z){
				$this->rand->setSeed((($x * $seedInt1) + ($z * $seedInt2)) ^ $level->getSeed());
				$this->recursiveGenerate($level, $x, $z, $chunkX, $chunkZ);
			}
		}
	}
	
	public function recursiveGenerate(Level $level, $chunkXoffsetted, $chunkZoffsetted, $chunkX, $chunkZ){}
}

