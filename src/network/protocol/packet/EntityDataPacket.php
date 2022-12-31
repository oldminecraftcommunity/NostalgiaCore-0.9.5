<?php

class EntityDataPacket extends RakNetDataPacket{
	public $x;
	public $y;
	public $z;
	public $namedtag;
	
	public function pid(){
		return ProtocolInfo::ENTITY_DATA_PACKET;
	}
	
	public function decode(){
		$this->x = $this->getShort();
		$this->y = $this->getByte();
		$this->z = $this->getShort();
		$this->namedtag = $this->get(true);
	}
	
	public function encode(){
		$this->reset();
		$this->putShort($this->x);
		$this->putByte($this->y);
		$this->putShort($this->z);
		$this->put($this->namedtag);
	}

}