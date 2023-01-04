<?php

class PathTileXYZ extends PathTile
{
	public $x, $y, $z;
	
	/**
	 * @var Level
	 */
	public $level;
	
	public function __construct($x, $y, $z, $level){
		$this->x = floor($x);
		$this->y = floor($y);
		$this->z = floor($z);
		$this->level = $level;
	}
	
	public function equals(PathTile $t){
		return $t->x === $this->x && $t->y === $this->y && $t->z === $this->z;
	}
	
	public function asVector(){
		return new Vector3($this->x, $this->y, $this->z);
	}
	
	public function asArray(){
		return ["x" => $this->x, "y" => $this->y, "z" => $this->z];
	}
	
	public function addOffset($offset){
		return new PathTileXYZ($this->x + $offset[0], $this->y + $offset[1], $this->z + $offset[2], $this->level);
	}
	
	public function __toString(){
		return $this->x.":".$this->y.":".$this->z;
	}
}

