<?php

interface IDistanceAlgorithm
{
	public function calculate(PathTile $from, PathTile $to);
}

