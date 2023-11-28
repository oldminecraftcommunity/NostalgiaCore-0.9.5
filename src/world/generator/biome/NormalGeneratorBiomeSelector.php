<?php

class NormalGeneratorBiomeSelector extends BiomeSelector
{
	public function getBiomeTR($t, $r){
		if($r < 0.60){
			if($t < 0.75){
				return BIOME_PLAINS;
			}else{
				return BIOME_DESERT;
			}
		}else if($r < 0.80){
			if($t < 0.25){
				return BIOME_TAIGA;
			}else if($t < 0.75){
				return BIOME_FOREST;
			}else{
				return BIOME_JUNGLE;
			}
		}
		return BIOME_PLAINS;
	}
}

