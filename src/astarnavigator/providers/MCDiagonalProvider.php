<?php

class MCDiagonalProvider implements INeighborProvider
{
	private static $neighbors = array([ 0, 0, -1 ], [ 1, 0, 0 ], [ 0, 0, 1 ], [ -1, 0, 0 ], [ -1, 0, -1 ], [ 1, 0, -1 ], [ 1, 0, 1 ], [ -1, 0, 1 ]);
	public function getNeighbors(PathTile $tile)
	{
		
		if($tile instanceof PathTileXYZ){
			$result = [];
			foreach(self::$neighbors as $offset){
				$t = clone $tile;
				$result[] = $t->addOffset($offset);
			}
			return $result;
		}
		return [];
	}

	
}

