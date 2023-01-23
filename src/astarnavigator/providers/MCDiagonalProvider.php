<?php

class MCDiagonalProvider implements INeighborProvider
{
	private static $neighbors = array([ 0, 0, -1 ], [ 1, 0, 0 ], [ 0, 0, 1 ], [ -1, 0, 0 ]);
	private static $jumpOffset = [0, 1, 0];
	private static $moveDownOffset = [0, -1, 0];
	public function getNeighbors(PathTile $tile)
	{
		
		if($tile instanceof PathTileXYZ){
			$pnts = [];
			foreach(MCDiagonalProvider::$neighbors as $offset){
				$pnt = $tile->addOffset($offset);
				if(!$tile->level->getBlockWithoutVector($pnt->x, $pnt->y, $pnt->z, false)->isSolid){
					if(!$tile->level->getBlockWithoutVector($pnt->x, $pnt->y - 1, $pnt->z, false)->isSolid){
						--$pnt->y;
					}
					$pnts[] = $pnt;
				}else{
					if(!$tile->level->getBlockWithoutVector($pnt->x, $pnt->y + 1, $pnt->z, false)->isSolid){
						++$pnt->y;
						$pnts[] = $pnt;
					}
				}
			}
			return $pnts;
		}
		return [];
	}

	
}

