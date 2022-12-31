<?php

interface ITileNavigator
{
	public function navigate(PathTile $from, PathTile $to, $maxDist);
}

