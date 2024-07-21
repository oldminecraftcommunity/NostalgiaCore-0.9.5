<?php

class ContainerOpenPacket extends RakNetDataPacket{
	public $windowid;
	public $type;
	public $slots;
	public $x;
	public $y;
	public $z;
	
	public function pid(){
		return ProtocolInfo::CONTAINER_OPEN_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putByte($this->windowid);
		$this->putByte($this->type);
		$this->putByte($this->slots);
		$this->putInt($this->x);
		$this->putInt($this->y);
		$this->putInt($this->z);
	}

}