<?php

interface IBlockedProvider
{
	/**
	 * @param Tile $tile
	 * 
	 * @return boolean
	 */
	public function isBlocked(PathTile $tile);
}

