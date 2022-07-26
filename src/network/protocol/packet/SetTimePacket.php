<?php

class SetTimePacket extends RakNetDataPacket{
	public $time;
	public $started = true;
	
	public function pid(){
		return ProtocolInfo::SET_TIME_PACKET;
	}
	
	public function decode(){

	}	
	
	public function encode(){
		$this->reset();
		$this->putInt($this->time);
		$this->putByte($this->started == true ? 0x80:0x00);
	}

}