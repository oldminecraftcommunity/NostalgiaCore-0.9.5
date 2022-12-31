<?php

class SetHealthPacket extends RakNetDataPacket{
	public $health;
	
	public function pid(){
		return ProtocolInfo::SET_HEALTH_PACKET;
	}
	
	public function decode(){
		$this->health = $this->getByte();
	}
	
	public function encode(){
		$this->reset();
		$this->putByte($this->health);
	}

}