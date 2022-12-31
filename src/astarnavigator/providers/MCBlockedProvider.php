<?php


class MCBlockedProvider implements IBlockedProvider
{
	public function isBlocked(PathTile $tile)
	{
		if($tile instanceof PathTileXYZ){
			$b = $tile->level->getBlockWithoutVector($tile->x, $tile->y, $tile->z);
			return $b instanceof Block && $b->isSolid;
		}
		return false;
	}

}

