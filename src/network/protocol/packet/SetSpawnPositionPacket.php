<?php

class SetSpawnPositionPacket extends RakNetDataPacket{
	public $x;
	public $z;
	public $y;
	
	public function pid(){
		return ProtocolInfo::SET_SPAWN_POSITION_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->x);
		$this->putInt($this->z);
		$this->putByte($this->y);
	}

}