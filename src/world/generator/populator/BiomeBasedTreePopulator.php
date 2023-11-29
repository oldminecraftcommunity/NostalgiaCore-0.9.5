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
			$biome = BiomeSelector::get($biomeID);
			$treeFeature = null;
			if($biome instanceof Biome){
				$treeFeature = $biome->getTree($random);
			}
			
			if($treeFeature instanceof TreeObject){
				$y = $this->getHighestWorkableBlock($x, $z);
				if($y === -1){
					continue;
				}
				$v3 = new Vector3($x, $y, $z); //TODO no v3
				if($treeFeature->canPlaceObject($level, $v3, $random)){
					$treeFeature->placeObject($level, $v3, $random);
				}
			}else{
				continue;
			}
		}
	}
}

