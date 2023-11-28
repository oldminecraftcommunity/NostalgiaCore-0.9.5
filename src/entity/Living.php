<?php

abstract class Living extends Entity implements Damageable, Pathfindable{
	
	public static $despawnMobs, $despawnTimer;
	
	public $target, $ai;
	public $pathFinder, $path = null, $currentIndex = 0, $currentNode, $pathFollower;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		$this->target = false;
		$this->ai = new EntityAI($this);
		$this->pathFinder = new TileNavigator(new MCBlockedProvider(), new MCDiagonalProvider(), new ManhattanHeuristic3D());
		$this->pathFollower = new PathFollower($this);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->canBeAttacked = true;
		$this->hasGravity = true;
		$this->hasKnockback = true;
		if(self::$despawnMobs) $this->server->schedule(self::$despawnTimer, [$this, "close"]); //900*20
	}
	
	public function hasPath(){
		return $this->path != null;
	}
	
	public function close(){
		parent::close();
		unset($this->pathFollower->entity);
		unset($this->ai->entity);
		unset($this->ai->mobController->entity);
		unset($this->ai);
		unset($this->parent);
	}
	
	public function update(){
		if($this->closed) return;
		if(!$this->dead && Entity::$allowedAI && $this->idleTime <= 0) {
			$this->ai->updateTasks();
		}
		$this->ai->mobController->rotateTick();
		if($this->onGround){
			//if(!$this->hasPath() && $this->pathFinder instanceof ITileNavigator){
			//	$this->path = $this->pathFinder->navigate(new PathTileXYZ($this->x, $this->y, $this->z, $this->level), new PathTileXYZ($this->x + mt_rand(-10, 10), $this->y + mt_rand(-1, 1), $this->z + mt_rand(-10, 10), $this->level), 10);
			//}
			$this->pathFollower->followPath();
		}
		
		
		parent::update();
	}
	
	public function sendMoveUpdate(){
		if($this->counter % 3 != 0){
			return;
		}
		parent::sendMoveUpdate();
		
	}
}
