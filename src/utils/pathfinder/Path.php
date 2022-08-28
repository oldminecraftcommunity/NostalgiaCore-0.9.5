<?php

class Path{
	public $points = [];
	public $currentPointIndex = 0;
	public function addPoint(Node $point){
		$this->points[] = $point;
	}
	
	public function getPointAndIncreaseIndex(){
		return $this->points[$this->currentPointIndex++];
	}
	
	public function increaseIndexAndGetPoint(){
		return isset($this->points[$this->currentPointIndex + 1]) ? $this->points[++$this->currentPointIndex] : null;
	}
	
	public function finish(){
		$this->points = array_reverse($this->points);
	}
}