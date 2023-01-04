<?php

class PropertyEntity{
	private $class,$type,$name;
	
	function __construct($class, $type, $name){
		$this->class = $class;
		$this->type = $type;
		$this->name = $name;
	}
	
	public function getEntityClass(){
		return $this->class;
	}
	public function getEntityType(){
		return $this->type;
	}
	public function getEntityName(){
		return $this->name;
	}
}