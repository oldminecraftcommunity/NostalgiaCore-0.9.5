<?php

class PathFollower{
	/**
	 * @var Living
	 */
	public $entity;
	
	public function __construct(Living $entity){
		$this->entity = $entity;
	}
	
	public function followPath(){
		if($this->entity->path != null && (is_array($this->entity->path) && count($this->entity->path) <= 0 || $this->entity->currentIndex >= count($this->entity->path))){
			$this->entity->path = null;
			$this->entity->currentIndex = 0;
			$this->entity->currentNode = false;
		}elseif($this->entity->path != null && ($this->entity->currentNode == false || $this->entity->ai->mobController->moveTo($this->entity->currentNode->x, $this->entity->currentNode->y, $this->entity->currentNode->z) === false)){
			$this->entity->currentNode = $this->entity->path[$this->entity->currentIndex++];
		}
	}
	
}

