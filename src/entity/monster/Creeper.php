<?php
class Creeper extends Monster{
	const TYPE = MOB_CREEPER;
	const EXPL_TIME = 30;
	public $timeUntilExplode;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 1.7);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 16, "generic");
		$this->setName("Creeper");
		$this->ignited = 0;
		$this->setSpeed(0.25);
		$this->update();
		$this->timeUntilExplode = $this->isIgnited() ? self::EXPL_TIME : 0;
	}
	
	public function getAttackDamage(){
		return 0; //TODO special attack
	}
	
	public function setIgnited($v = null){
		$this->setState($v === null ? !$this->getState() : $v);	
	}
	
	
	
	/**
	 * @return boolean
	 */
	public function isIgnited(){
		return $this->getState() > 0;
	}
	
	public function interactWith(Entity $e, $action){
		if($e->isPlayer() && $action === InteractPacket::ACTION_HOLD){
			$slot = $e->player->getHeldItem();
			if($slot->getID() === FLINT_AND_STEEL && !$this->isIgnited()){
				if($slot->useOn($this) && $slot->getMetadata() >= $slot->getMaxDurability()){
					$e->player->removeItem($slot->getID(), $slot->getMetadata(), $slot->count, true);
				}else{
					$e->player->setSlot($e->player->slot, $slot);
				}
				$this->ignite();
				return true;
			}
		}
		return parent::interactWith($e, $action);
	}
	
	public function ignite(){
		$this->setIgnited(1);
		$this->timeUntilExplode = self::EXPL_TIME;
	}
	
	public function attackEntity($entity){
		if(Utils::distance_noroot($entity, $this) <= 49 && !$this->isIgnited()){
			$this->ignite();
		}
		
	}
	public function update(){
		if($this->isIgnited() && $this->target instanceof Entity && Utils::distance_noroot($this->target, $this) > 49){
			$this->setIgnited(-1); //broken in vanilla too
			$this->timeUntilExplode = 0;
		}
		if($this->timeUntilExplode === 1){
			$this->explode();
		}
		if($this->timeUntilExplode >= 0){
			--$this->timeUntilExplode;
		}
		parent::update();
	}

	public function explode()
	{
		if($this->closed || $this->dead){
			return false;
		}
		$this->setIgnited(0);
		$explosion = new Explosion($this, 3);
		$this->close();
		$explosion->explode();
	}
	
	public function getDrops(){
		return [
			[GUNPOWDER, 0, mt_rand(0,2)]
		];
	}
}
