<?php

class LoginPacket extends RakNetDataPacket{
	public $username;
	public $protocol1;
	public $protocol2;
	public $clientId;
	public $loginData;
	
	public function pid(){
		return ProtocolInfo::LOGIN_PACKET;
	}
	
	public function decode(){
		$this->username = $this->getString();
		$this->protocol1 = $this->getInt();
		$this->protocol2 = $this->getInt();
		$this->clientId = $this->getInt();
		$this->loginData = $this->getString();
	}	
	
	public function encode(){
		
	}

}