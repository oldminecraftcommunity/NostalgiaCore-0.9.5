<?php

class EmptyBlockedProvider implements IBlockedProvider
{
	public function isBlocked(PathTile $tile)
	{
		return false;
	}
}

