<?php

class MessagePacket extends RakNetDataPacket{
	public $source;
	public $message;
	
	public function pid(){
		return ProtocolInfo::MESSAGE_PACKET;
	}
	
	public function decode(){
		$this->source = $this->getString();
		$this->message = $this->getString();
	}	
	
	public function encode(){
		$this->reset();
		$this->putString($this->source);
		$this->putString($this->message);
	}

}