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
		
		if(!isset($this->entity) || !($this->entity instanceof Living)) return;
		if(!$this->entity->hasPath()) return;
		
		if($this->entity->currentNode == null){
			$this->entity->currentNode = $this->entity->path[$this->entity->currentIndex];
		}
		$moveX = ($this->entity->currentNode >> 16 & 0xff) + 0.5;
		$moveY = $this->entity->currentNode & 0xff;
		$moveZ = ($this->entity->currentNode >> 8 & 0xff) + 0.5;
		$this->entity->ai->mobController->setMovingTarget($moveX, $moveY, $moveZ, 1.0);
		if($this->entity->boundingBox->isXYZInsideNS($moveX, $moveY, $moveZ)){
			++$this->entity->currentIndex;
			//console("next");
			$this->entity->currentNode = null;
		}
		
		
		if($this->entity->currentIndex >= count($this->entity->path)){
			console("path finished.");
			$this->entity->currentNode = null;
			$this->entity->path = null;
			$this->entity->currentIndex = 0;
			
			/*foreach($this->entity->pathEIDS as $eid){
				$pk = new RemoveEntityPacket();
				$pk->eid = $eid;
				foreach($this->entity->level->players as $player){
					$player->dataPacket($pk);
				}
			}*/
			
		}
	}
	
}

