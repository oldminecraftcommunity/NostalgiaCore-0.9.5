<?php
class Monster extends Creature{
	
	public $closestPlayerToAttackEID = false;
	public $closestPlayerToAttackDist = INF;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
	}
	
	public function getAttackDamage(){
		return 2;
	}
	/**
	 * 
	 * @see Entity::attackEntity()
	 */
	public function attackEntity($entity, $distance){
		if($distance < 2.0 && $entity->boundingBox->maxX > $this->boundingBox->minY && $entity->boundingBox->minY < $this->boundingBox->maxY){
			$entity->harm($this->getAttackDamage(), $this->eid);
			return true;
		}else{
			return false;
		}
	}
	
	public function isPlayerValid(Player $player){
		return $player->spawned && !$player->entity->dead;
	}
	
	public function handlePrePlayerSearcher(){
		parent::handlePrePlayerSearcher();
		if($this->closestPlayerToAttackEID !== false){
			$player = $this->level->entityList[$this->closestPlayerToAttackEID] ?? false;
			if($player === false || !$this->isPlayerValid($player->player)){
				$this->closestPlayerToAttackEID = false;
				$this->closestPlayerToAttackDist = INF;
			}else{
				$dist = ($this->x - $player->x)*($this->x - $player->x) + ($this->y - $player->y)*($this->y - $player->y) + ($this->z - $player->z)*($this->z - $player->z);
				$this->closestPlayerToAttackDist = $dist;
			}
		}
	}
	
	public function handlePlayerSearcher(Player $player, $dist){
		parent::handlePlayerSearcher($player, $dist);
		
		if($this->closestPlayerToAttackDist >= $dist){
			if($this->isPlayerValid($player)){
				$this->closestPlayerToAttackDist = $dist;
				$this->closestPlayerToAttackEID = $player->entity->eid;
			}
		}
	}
	
}
