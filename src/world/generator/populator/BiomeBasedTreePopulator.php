<?php

class BiomeBasedTreePopulator extends \TreePopulator
{
	public function populate(Level $level, $chunkX, $chunkZ, Random $random){
		$this->level = $level;
		$amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
		for($i = 0; $i < $amount; ++$i){
			$x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
			$z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
			$biomeID = $level->level->getBiomeId($x, $z);
			switch($biomeID){
				case BIOME_FOREST:
					$f = $random->nextFloat();
					if($f > 0.75){
						$meta = SaplingBlock::BIRCH;
					}else{
						$meta = SaplingBlock::OAK;
					}
					break;
				case BIOME_JUNGLE:
					$meta = SaplingBlock::JUNGLE;
					break;
				case BIOME_TAIGA:
					$meta = SaplingBlock::SPRUCE;
					break;
				case BIOME_PLAINS:
					$f = $random->nextFloat();
					if($f > 0.9){
						$meta = SaplingBlock::OAK;
						break;
					}
					return;
				default:
					return;
			}
			$y = $this->getHighestWorkableBlock($x, $z);
			if($y === -1){
				continue;
			}
			TreeObject::growTree($this->level, new Vector3($x, $y, $z), $random, $meta);
		}
	}
}

