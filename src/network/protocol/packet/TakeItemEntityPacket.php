<?php

class TakeItemEntityPacket extends RakNetDataPacket{
	public $target;
	public $eid;

	public function pid(){
		return ProtocolInfo::TAKE_ITEM_ENTITY_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->target);
		$this->putInt($this->eid);
	}

}