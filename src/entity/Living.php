<?php

abstract class Living extends Entity implements Damageable, Pathfindable{
	public $target, $ai;
	
	public $pathFinder, $path = null, $currentIndex = 0, $currentNode, $pathFollower;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		$this->target = false;
		$this->ai = new EntityAI($this);
		$this->pathFinder = new TileNavigator(new MCBlockedProvider(), new MCDiagonalProvider(), new ManhattanHeuristic3D(), new ManhattanHeuristic3D());
		$this->pathFollower = new PathFollower($this);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->canBeAttacked = true;
		$this->hasGravity = true;
		$this->hasKnockback = true;
	}
	
	public function hasPath(){
		return $this->path != null;
	}
	
	public function __destruct()
	{
		parent::__destruct();
		unset($this->pathFollower->entity);
		unset($this->ai->entity);
	}
	
	public function update(){
		if(Entity::$allowedAI && $this->idleTime <= 0) {
			$this->ai->updateTasks();
		}
		
		if($this->onGround){
			//if(!$this->hasPath() && $this->pathFinder instanceof ITileNavigator){ // mt_rand(0, 120) === 0){
			//	$this->path = $this->pathFinder->navigate(new PathTileXYZ($this->x, $this->y, $this->z, $this->level), new PathTileXYZ($this->x + mt_rand(-10, 10), $this->y, $this->z + mt_rand(-10, 10), $this->level), 10);
			//}
			$this->pathFollower->followPath();
		}
		
		
		parent::update();
	}
	
}
