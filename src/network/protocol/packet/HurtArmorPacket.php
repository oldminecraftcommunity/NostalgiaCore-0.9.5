<?php

class HurtArmorPacket extends RakNetDataPacket{
	public $health;
	
	public function pid(){
		return ProtocolInfo::HURT_ARMOR_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putByte($this->health);
	}

}