<?php

class EntityEventPacket extends RakNetDataPacket{
	public $eid;
	public $event;
	
	const ENTITY_DAMAGE = 2;
	
	public function pid(){
		return ProtocolInfo::ENTITY_EVENT_PACKET;
	}
	
	public function decode(){
		$this->eid = $this->getInt();
		$this->event = $this->getByte();
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putByte($this->event);
	}

}