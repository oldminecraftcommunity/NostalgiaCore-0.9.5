<?php

class StructureAABB extends \AxisAlignedBB
{
	public function __construct($minX, $minY, $minZ, $maxX, $maxY = 0, $maxZ = 0){
		if(func_num_args() == 4) parent::__construct($minX, 1, $minY, $minZ, 512, $maxX); //why no overloading
		else parent::__construct($minX, $minY, $minZ, $maxX, $maxY, $maxZ);
	}
	
	public function intersectsWith($bb, $minZ = 0, $maxX = 0, $maxZ = 0){
		if($bb instanceof AxisAlignedBB){
			return $this->intersectsWith($bb->minX, $bb->minZ, $bb->maxX, $bb->maxZ);
		}
		return $this->maxX >= $bb && $this->minX <= $maxX && $this->maxZ >= $minZ && $this->minZ <= $maxZ;
	}
	
}

