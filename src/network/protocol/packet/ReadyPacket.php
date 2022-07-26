<?php

class ReadyPacket extends RakNetDataPacket{
	public $status;
	
	public function pid(){
		return ProtocolInfo::READY_PACKET;
	}
	
	public function decode(){
		$this->status = $this->getByte();
	}	
	
	public function encode(){

	}

}