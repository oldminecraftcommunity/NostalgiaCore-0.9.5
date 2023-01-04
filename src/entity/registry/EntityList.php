<?php

class EntityList{
	public function getEntities(){
		return $this->entities;
	}
	public function addEntity(PropertyEntity $property){
		$this->entities[$property->getEntityType()] = $property;
	}
	public function getEntityFromTypeAndClass($type, $class){
		return isset($this->entities[$type]) && $this->entities[$type]->getEntityClass() === $class ? $this->entities[$type] : 0;
	}
	private $entities = [];
}
