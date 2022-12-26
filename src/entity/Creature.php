<?php
/*
TODO:
move methods
*/
abstract class Creature extends Living{
	const CLASS_TYPE = ENTITY_MOB;
	
	public $pathFinder, $path = null, $currentIndex = 0, $currentNode;
	
	public $inPanic;
	
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->inPanic = false; //force for now
		$this->pathFinder = new TileNavigator(new MCBlockedProvider(), new MCDiagonalProvider(), new Pythagoras3D(), new ManhattanHeuristic3D());
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 1, "generic");
		//$this->setName((isset($mobs[$this->type]) ? $mobs[$this->type]:$this->type));
		if(Entity::$updateOnTick){
			$this->ai->addTask(new TaskLookAround());
			$this->ai->addTask(new TaskRandomWalk());
			$this->ai->addTask(new TaskLookAtPlayer());
		}
		
	}
	
	public function update(){
		if($this->onGround){
			/*if($this->path === null && $this->pathFinder instanceof ITileNavigator){ // mt_rand(0, 120) === 0){
				$this->path = $this->pathFinder->navigate(new PathTileXYZ($this->x, $this->y, $this->z, $this->level), new PathTileXYZ($this->x + mt_rand(-10, 10), $this->y, $this->z + mt_rand(-10, 10), $this->level));
			}
			if($this->path != null && (is_array($this->path) && count($this->path) <= 0 || $this->currentIndex >= count($this->path))){
				$this->path = null;
				$this->currentIndex = 0;
				$this->currentNode = false;
			}elseif($this->path != null && ($this->currentNode == false || $this->ai->mobController->moveTo($this->currentNode->x, $this->currentNode->y, $this->currentNode->z) === false)){
				$this->currentNode = $this->path[$this->currentIndex++];
			}*/
		}
		parent::update();
		
	}
	
	public function createSaveData(){
		$data = parent::createSaveData();
		$data["State"] = @$this->getState();
		return $data;
	}
	
	public function getSpeedModifer(){
		return $this->speedModifer * ($this->inPanic ? 1.4 : 0.7);
	}
	
	public function spawn($player){
		if(!($player instanceof Player)){
			$player = $this->server->api->player->get($player);
		}
		if($player->eid === $this->eid or $this->closed !== false or ($player->level !== $this->level and $this->class !== ENTITY_PLAYER)){
			return false;
		}
		$pk = new AddMobPacket;
		$pk->eid = $this->eid;
		$pk->type = $this->type;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->getMetadata();				
		$player->dataPacket($pk);
				
		$pk = new SetEntityMotionPacket;
		$pk->eid = $this->eid;
		$pk->speedX = $this->speedX;
		$pk->speedY = $this->speedY;
		$pk->speedZ = $this->speedZ;
		$player->dataPacket($pk);
	}
	
}
