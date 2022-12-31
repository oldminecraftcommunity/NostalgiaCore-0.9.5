<?php

class LoginStatusPacket extends RakNetDataPacket{
	public $status;
	
	public function pid(){
		return ProtocolInfo::LOGIN_STATUS_PACKET;
	}
	
	public function decode(){

	}	
	
	public function encode(){
		$this->reset();
		$this->putInt($this->status);
	}

}