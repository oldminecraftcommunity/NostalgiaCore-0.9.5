<?php

class DisconnectPacket extends RakNetDataPacket{
	public function pid(){
		return ProtocolInfo::DISCONNECT_PACKET;
	}
	
	public function decode(){

	}	
	
	public function encode(){
		$this->reset();	
	}

}