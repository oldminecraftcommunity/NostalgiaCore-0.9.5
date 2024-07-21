<?php

class SetEntityMotionPacket extends RakNetDataPacket{
	public $eid;
	public $speedX;
	public $speedY;
	public $speedZ;
	
	public function pid(){
		return ProtocolInfo::SET_ENTITY_MOTION_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putShort((int) ($this->speedX * 8000));
		$this->putShort((int) ($this->speedY * 8000));
		$this->putShort((int) ($this->speedZ * 8000));
	}

}