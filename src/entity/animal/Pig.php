<?php
class Pig extends Animal{
	const TYPE = MOB_PIG;
	public $pathFinder, $path, $server;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->pathFinder = new Pathfinder($this);
		$this->update();
		$this->server = ServerAPI::request();
		//$this->server->schedule(60, array($this, "testMovement"));
		//$this->setName('Pig');
		$this->size = $this->isBaby() ? 0.60 : 1.1875;
	}
	public function isFood($id){
		return $id === POTATO || $id === CARROT || $id === BEETROOT;
	}
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : 
		array(
			array(($this->fire > 0 ? COOKED_PORKCHOP:RAW_PORKCHOP), 0, mt_rand(0,2)),
		);
	}
	public function testMovement(){ //test movement, move 1 block each 10 seconds, looks terrible ingame
		$this->pathFinder->updateEntityPos(ceil($this->x), ceil($this->y), ceil($this->z));
		$this->path = $this->pathFinder->buildTo(new Vector3(ceil($this->x) + mt_rand(0,4), ceil($this->y), ceil($this->z) + mt_rand(0,4)));
		$this->followPath();
	}
	
	public function followPath(){
		$point = null;
		if($this->path instanceof Path){
			$point = $this->path->increaseIndexAndGetPoint();
		}else{
			$this->server->schedule(40, array($this, "testMovement"), false);
			return;
		}
		if($point != null){
			console($point);
			$xDiff = $point->x - $this->x;
			$zDiff = $point->z - $this->z;
			console($this);
			$this->move(new Vector3($xDiff, 0, $zDiff), $this->yaw, $this->pitch);
			$this->updateMovement();
			$this->handleUpdate($this);
			$this->server->schedule(10, array($this, "followPath"), false);
		}else{
			$this->server->schedule(40, array($this, "testMovement"), false);
		}
		
	}
	public function handleUpdate($entity){
		$players = $this->server->api->player->getAll($entity->level);
		$pk = new MoveEntityPacket_PosRot;
		$pk->eid = $entity->eid;
		$pk->x = $entity->x;
		$pk->y = $entity->y;
		$pk->z = $entity->z;
		$pk->yaw = $entity->yaw;
		$pk->pitch = $entity->pitch;
		$this->server->api->player->broadcastPacket($players, $pk);
	}
}
