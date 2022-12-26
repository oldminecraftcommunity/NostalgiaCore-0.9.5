<?php

class ArrayList{
	public $arr = [];
	public function add(IElement $e){
		$this->arr[$e->__toString()] = $e;
		return $this;
	}
	
	public function addAll($es){
		foreach($es as $e){
			$this->add($this->add($e));
		}
	}
	
	public function getFirst(){
		return array_values($this->arr)[0];
	}
	
	public function remove(IElement $e){
		unset($this->arr[$e->__toString()]);
		return $this;
	}
	
	public function __isset($e){
		return isset($this->arr[$e->__toString()]);
	}
	
	public function has(IElement $e){
		return isset($this->arr[$e->__toString()]);
	}
	
	public function sortWith($func){
		return uasort($this->arr, $func);
	}
	
	public function countElements(){
		return count($this->arr);
	}
}
