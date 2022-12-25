<?php

class ManhattanHeuristicAlgorithm implements IDistanceAlgorithm
{
    public function calculate(PathTile $from, PathTile $to)
    {
        return abs($from->x - $to->x) + abs($from->y - $to->y);
    }

    
}

