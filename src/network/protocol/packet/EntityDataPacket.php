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
		$this->x = $this->getInt();
		$this->y = $this->getByte();
		$this->z = $this->getInt();
		$this->namedtag = $this->get(true);
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->x);
		$this->putByte($this->y);
		$this->putInt($this->z);
		$this->put($this->namedtag);
	}

}