<?php

class Pathfinder{
	const NO_PATH_FOUND = "NO_PATH";
	private $entity;
	private $openList, $closedList;
	
	public function __construct($entity, $avoidWater = true){ //avoid - WIP
		$this->entity = $entity;
	}
	
	public function updateEntityPos($x, $y, $z){
		$this->entity->x = $x;
		$this->entity->y = $y;
		$this->entity->z = $z;
	}
	
	public function buildTo($end){
		$goal = Node::loadFromVector3($end); //247 68 215
		$this->openList[] = new Node(ceil($this->entity->x), ceil($this->entity->y), ceil($this->entity->z), 0, 0, 0);
		$this->closedList = [];
		$cnt = 0;
		while(!empty($this->openList)){
			$currentIndex = 0;
			$currentNode = $this->openList[$currentIndex];
			foreach($this->openList as $index => $node){
				if($node->f < $currentNode->f){
					$currentIndex = $index;
					$currentNode = $node;
				}
			}
			array_splice($this->openList, $currentIndex, 1);
			$this->closedList[] = $currentNode;
			if($currentNode->equals($goal)){
				$path = new Path();
				$current = $currentNode;
				while($current != null){
					$path->addPoint($current);
					$current = $current->parent;
				}
				$path->finish();
				return $path;
			}
			$children = [];
			//y was removed
			for($x = -1; $x <= 1; $x++){
				for($z = -1; $z <= 1; $z++){
					$nodePosition = new Vector3($currentNode->x + $x, $currentNode->y, $currentNode->z + $z);
					if(!$this->isPositionValid($nodePosition)){
						continue;
					}
					if($currentNode->equals($nodePosition)){
						continue;
					}
					$node = Node::loadFromVector3($nodePosition, $currentNode);
					$children[] = $node;
				}
			}
			
			foreach($children as $child){
				foreach($this->closedList as $closed){
					if($child->equals($closed)){
						goto exitLoopLbl;
					}
				}
				exitLoopLbl:
				$child->g = $currentNode->g + 1;
				$child->h = $child->calcH($end);
				$child->f = $child->g + $child->h;
				
				$this->openList[] = $child;
				
			}

			$cnt++;
			if($cnt === 6){
				break;
			}
		}
		
		return Pathfinder::NO_PATH_FOUND;
		
	}
	
	public function isPositionValid($nodePosition){
		return $nodePosition->x >= 0 && $nodePosition->x < 256 && $nodePosition->y > 0 && $nodePosition->y < 128 && $nodePosition->z >= 0 && $nodePosition->z < 256 && $this->isEmpty($nodePosition);
	}
	public function distanceBetween($p1, $p2){
		return sqrt(pow(($p1->x - $p2->x),2) + pow(($p1->y - $p2->y),2) + pow(($p1->z - $p2->z),2));
	}
	
	public function isEmpty($v3){
		return !$this->entity->level->getBlock($v3)->isSolid;
	}
	
}