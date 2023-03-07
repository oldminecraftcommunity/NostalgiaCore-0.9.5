<?php

class GroundCover extends Populator
{
	public function populate(Level $level, $chunkX, $chunkZ, Random $random)
	{
		console("gcpop: $chunkX $chunkZ");
		$waterHeight = 0; //TODO
		for($x = 0; $x < 16; ++$x){
			for($z = 0; $z < 16; ++$z){
				$pcx = ($chunkX << 4) + $x;
				$pcz = ($chunkZ << 4) + $z;
				$biome = BiomeSelector::get($level->level->getBiomeId($pcx, $pcz));
				$cover = $biome->getTopBlocks();
				if(count($cover) > 0){
					$diffY = 0;
					
					if(!BlockAPI::get($cover[0][0], $cover[0][1])->isSolid){
						$diffY = 1;
					}
					
					$column = $level->level->getBlockIDsXZ($pcx, $pcz);
					for($y = 127; $y > 0; --$y){
						$chunkY = $y >> 4;
						$b = $column[$chunkY][(($y & 0xf) + ($x << 6) + ($z << 10))];
						if($b !== "\x00" and !BlockAPI::get(ord($b))->isTransparent){
							break;
						}
					}
					$startY = min(127, $y + $diffY);
					$endY = $startY - count($cover);
					for($y = $startY; $y > $endY and $y >= 0; --$y){
						$chunkY = $y >> 4;
						$pair = $cover[$startY - $y];
						$b = BlockAPI::get($pair[0], $pair[1]);
						if($column[$chunkY][(($y & 0xf) + ($x << 6) + ($z << 10))] === "\x00" and $b->isSolid){
							break;
						}
						if($y <= $waterHeight and $b->getID() == GRASS and $level->level->getBlockID($pcx, $y + 1, $pcz) == STILL_WATER){
							$b = BlockAPI::get(DIRT);
						}
						if($b->getMetadata() === 0){
							$level->level->setBlockId($pcx, $y, $pcz, $b->getID());
						}else{
							$level->level->setBlock($pcx, $y, $pcz, $b->getID(), $b->getMetadata());
						}
					}
				}
			}
		}
	}

	
}

