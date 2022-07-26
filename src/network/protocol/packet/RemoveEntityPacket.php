<?php

class RemoveEntityPacket extends RakNetDataPacket{
	public $eid;

	public function pid(){
		return ProtocolInfo::REMOVE_ENTITY_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
	}

}