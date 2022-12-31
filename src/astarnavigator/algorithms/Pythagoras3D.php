<?php

class Pythagoras3D implements IDistanceAlgorithm
{
	public function calculate(PathTile $from, PathTile $to)
	{
		if($from instanceof PathTileXYZ && $to instanceof PathTileXYZ){
			return Utils::distance($from->asArray(), $to->asArray());
		}
		return 666;
	}

}

