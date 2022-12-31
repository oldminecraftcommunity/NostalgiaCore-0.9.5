<?php

class ChatPacket extends RakNetDataPacket{
	public $message;
	
	public function pid(){
		return ProtocolInfo::CHAT_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putString($this->message);
	}

}