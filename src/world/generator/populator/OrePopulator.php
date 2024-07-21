<?php

class OrePopulator extends Populator{

	private $oreTypes = [];

	public function populate(Level $level, $chunkX, $chunkZ, Random $random){
		foreach($this->oreTypes as $type){
			$ore = new OreObject($random, $type);
			for($i = 0; $i < $ore->type->clusterCount; ++$i){
				$x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 16);
				$y = $random->nextRange($ore->type->minHeight, $ore->type->maxHeight);
				$z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 16);
				if($ore->canPlaceObject($level, $x, $y, $z)){
					$ore->placeObject($level, new Vector3($x, $y, $z));
				}
			}
		}
	}

	public function setOreTypes(array $types){
		$this->oreTypes = $types;
	}
}