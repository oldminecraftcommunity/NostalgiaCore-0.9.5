<?php

class FlowerPatchPopulator extends Populator
{
	public static $flowerIDS = [
		[DANDELION, 0],
		[MULTIFLOWER, 0],
		[MULTIFLOWER, 1],
		[MULTIFLOWER, 2],
		[MULTIFLOWER, 3],
		[MULTIFLOWER, 4],
		[MULTIFLOWER, 5],
		[MULTIFLOWER, 6],
		[MULTIFLOWER, 7],
		[MULTIFLOWER, 8],
		
	];
	
	public function populate(Level $level, $chunkX, $chunkZ, Random $random)
	{
		$x = $chunkX*16 + $random->nextRange(0, 15);
		$z = $chunkZ*16 + $random->nextRange(0, 15);
		
		for($i = 0; $i < 4; ++$i){
			$xPos = ($x + $random->nextRange(0, 7)) - $random->nextRange(0, 7);
			$zPos = ($z + $random->nextRange(0, 7)) - $random->nextRange(0, 7);
			$yPos = $this->getHighestWorkableBlock($level, $xPos, $zPos);
			if($level->level->getBlockID($xPos, $yPos, $zPos) == 0){
				$flowerIDMeta = self::$flowerIDS[$random->nextRange(0, count(self::$flowerIDS)-1)];
				$level->level->setBlock($xPos, $yPos, $zPos, $flowerIDMeta[0], $flowerIDMeta[1]);
			}
		}
	}
	
	private function getHighestWorkableBlock(Level $level, $x, $z){
		for($y = 128; $y > 0; --$y){
			$b = $level->level->getBlockID($x, $y, $z);
			if($b == GRASS || $b == DIRT){
				return $y + 1;
			}
		}
		return -1;
	}
}

