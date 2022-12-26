<?php

class PathTile implements IElement
{
	public $x, $y;
	
	public function __construct($x, $y){
		$this->x = $x;
		$this->y = $y;
	}
	
	public function equals(PathTile $t){
		return $t->x === $this->x && $t->y === $this->y;
	}
	
	public function addOffset($offset){
		$this->x += $offset[0];
		$this->y += $offset[1];
		return $this;
	}
	
	public function __toString(){
		return $this->x.":".$this->y;
	}

}

