<?php

class Cow extends Animal{
	const TYPE = MOB_COW;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 10, "generic");
		$this->setSize($this->isBaby() ? 0.45 : 0.9 , $this->isBaby() ? 0.7 : 1.4);
		$this->setName("Cow");
		$this->setSpeed(0.2);
		$this->update();
	}
	
	public function isFood($id){
		return $id === WHEAT;
	}
	
	public function interactWith(Entity $e, $action){
		if($e->isPlayer() && $action === InteractPacket::ACTION_HOLD){
			$slot = $e->player->getHeldItem();
			if($slot->getID() === BUCKET && $slot->getMetadata() === 0){
				$e->player->removeItem($slot->getID(), $slot->getMetadata(), 1, true); //remove only 1 bucket
				$e->player->addItem(BUCKET, 1, 1, true);
				return true;
			}
		}
		parent::interactWith($e, $action);
	}
	
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : [	
			[LEATHER, 0, mt_rand(0,2)],
			[($this->fire > 0 ? STEAK : BEEF), 0, mt_rand(0, 3)]
		];
	}

}