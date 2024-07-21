<?php

class Position extends Vector3{

	public $level;

	public function __construct($x = 0, $y = 0, $z = 0, Level $level = null){
		if($x instanceof Vector3){
			parent::__construct($x->x, $x->y, $x->z);
		}else{
			$this->x = $x;
			$this->y = $y;
			$this->z = $z;
		}

		$this->level = $level;
	}
	public function setXYZLevel($x, $y, $z, Level $level){
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->level = $level;
	}
	public function getSide($side, $step = 1){
		return new Position(parent::getSide($side, $step), 0, 0, $this->level);
	}

	public function distance($x = 0, $y = 0, $z = 0){
		if(($x instanceof Position) and $x->level !== $this->level){
			return PHP_INT_MAX;
		}

		return parent::distance($x, $y, $z);
	}
	
	public function __toString(){
		return "Position(level=" . $this->level->getName() . ",x=" . $this->x . ",y=" . $this->y . ",z=" . $this->z . ")";
	}
}