<?php

class MCDiagonalProvider implements INeighborProvider
{
	private static $neighbors = array([ 0, 0, -1 ], [ 1, 0, 0 ], [ 0, 0, 1 ], [ -1, 0, 0 ], [ -1, 0, -1 ], [ 1, 0, -1 ], [ 1, 0, 1 ], [ -1, 0, 1 ]);
	public function getNeighbors(PathTile $tile)
	{
		
		if($tile instanceof PathTileXYZ){
			return array_map(function($offset) use($tile){
			    return $tile->addOffset($offset);
			}, MCDiagonalProvider::$neighbors);
		}
		return [];
	}

	
}

