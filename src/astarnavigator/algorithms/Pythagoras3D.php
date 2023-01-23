<?php
/**
 * No sqrt distance
 */
class Pythagoras3D implements IDistanceAlgorithm
{
	public function calculate(PathTile $from, PathTile $to)
	{
		if($from instanceof PathTileXYZ && $to instanceof PathTileXYZ){
			return Utils::distance_noroot($from->asArray(), $to->asArray());
		}
		return INF;
	}

}

