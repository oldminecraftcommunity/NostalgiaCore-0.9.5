<?php

class Node{
	public $g, $h, $f, $parent;
	public $x, $y, $z;
	public function __construct($x, $y, $z, $parent, $g = "U", $h = "U", $f = "U"){
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->parent = $parent;
		$this->g = $g;
		$this->h = $h;
		$this->f = $f;
	}
	public function __toString(){
		return "PathNode(x={$this->x}, y={$this->y}, z ={$this->z}, g={$this->g}, h={$this->h}, f={$this->f})"; 
	}
	public function calcH($endNode){
		return pow(($endNode->x - $this->x), 2) + pow(($endNode->y - $this->y), 2) + pow(($endNode->z - $this->z), 2); 
	}
	
	public function calcF(){
		return $this->h + $this->g;
	}
	
	public static function loadFromVector3($v3, $parent = null){
		return new Node($v3->x, $v3->y, $v3->z, $parent, 0, 0, 0);
	}
	
	public function equals($n){
		return $n->x == $this->x && $n->y == $this->y && $n->z == $this->z;
	}
	
}