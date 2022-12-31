<?php

class ClientConnectPacket extends RakNetDataPacket{
	public $clientID;
	public $session;
	public $unknown1;

	public function pid(){
		return ProtocolInfo::CLIENT_CONNECT_PACKET;
	}
	
	public function decode(){
		$this->clientID = $this->getLong();
		$this->session = $this->getLong();
		$this->unknown1 = $this->get(1);
	}	
	
	public function encode(){

	}

}