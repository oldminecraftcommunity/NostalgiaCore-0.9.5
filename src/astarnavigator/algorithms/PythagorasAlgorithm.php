<?php

class PythagorasAlgorithm implements IDistanceAlgorithm
{
    public function calculate(PathTile $from, PathTile $to)
    {
        return sqrt(pow($to->x - $from->x, 2) + pow($to->y - $from->y, 2));
    }

}

