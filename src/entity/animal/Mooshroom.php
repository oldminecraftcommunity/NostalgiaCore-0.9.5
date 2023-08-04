<?php

require_once("Cow.php");

class Mooshroom extends Cow{
	const TYPE = MOB_MOOSHROOM;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setName("Mooshroom");
		$this->update();
	}
	
	public function interactWith(Entity $e, $action){
		if($e->isPlayer() && $action === InteractPacket::ACTION_HOLD){
			$slot = $e->player->getHeldItem();
			if($slot->getID() === SHEARS){
                //drop
                $this->close();
                $this->server->api->entity->summon($this, ENTITY_MOB, MOB_COW, $this->data);
				return true;
			}
		}
		parent::interactWith($e, $action);
	}
}