<?php
class Vector3Pos extends Vector3
{
	public $x, $y, $z;
	
	public function __construct(&$x, &$y, &$z){
		$this->x = &$x;
		$this->y = &$y;
		$this->z = &$z;
	}
	
	public function addToValues($v){
		$this->x += $v->x;
		$this->y += $v->y;
		$this->z += $v->z;
		return $this;
	}
	
}

