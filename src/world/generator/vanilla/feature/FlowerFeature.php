<?php

class FlowerFeature extends Feature
{
	private $id;
	public function __construct($id){
		$this->id = $id;
	}
	
	public function place(Level $level, MTRandom $rand, $x, $y, $z){ //TODO pass VanillaGenerator instance and update heightmap on ceratin block placement
		for($i = 0; $i < 64; ++$i){
			$xPos = ($x + $rand->nextInt(8)) - $rand->nextInt(8);
			$yPos = ($y + $rand->nextInt(4)) - $rand->nextInt(4);
			$zPos = ($z + $rand->nextInt(8)) - $rand->nextInt(8);
			if($level->level->getBlockID($xPos, $yPos, $zPos) == 0){
				//TODO placement checking is a bit harder
				/*boolean res = world.canSeeSky(x, y, z);
				if(/*Level::getRawBrightness(a2, a3, a4, a5) > 7 TODO light ||*//* res) {
					int id = world.getBlockIDAt(x, y - 1, z);
					return id == Block.grass.blockID || id == Block.dirt.blockID || id == Block.farmland.blockID;
				}
				return res;*/
				$idDown = $level->level->getBlockID($xPos, $yPos - 1, $zPos);
				if($idDown == GRASS || $idDown == DIRT || $idDown == FARMLAND) $level->level->setBlockID($xPos, $yPos, $zPos, $this->id);
			}
		}
	}
}

