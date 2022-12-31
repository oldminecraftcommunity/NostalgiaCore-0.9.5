<?php

class InteractPacket extends RakNetDataPacket{
	const ACTION_HOLD = 1; //HOLD CLICK ON ENTITY
	const ACTION_ATTACK = 2; //SIMPLE CLICK(ATTACK)
	const ACTION_VEHICLE_EXIT = 3; //EXIT FROM ENTITY(MINECART)
	public $action;
	public $eid;
	public $target;

	public function pid(){
		return ProtocolInfo::INTERACT_PACKET;
	}
	
	public function decode(){
		$this->action = $this->getByte();
		$this->eid = $this->getInt();
		$this->target = $this->getInt();
	}
	
	public function encode(){
		$this->reset();
		$this->putByte($this->action);
		$this->putInt($this->eid);
		$this->putInt($this->target);
	}

}