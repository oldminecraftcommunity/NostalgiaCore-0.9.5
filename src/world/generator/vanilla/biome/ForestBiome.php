<?php

class ForestBiome extends Biome
{
	public function getTreeFeature(MTRandom $rand){
		if($rand->nextInt(5) == 0){
			return Feature::$BIRCH_TREE;
		}
		$rand->nextInt(); //it is necessary
		return Feature::$TREE;
	}
}

