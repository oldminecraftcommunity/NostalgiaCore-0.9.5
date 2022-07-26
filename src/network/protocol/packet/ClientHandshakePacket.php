<?php

class ClientHandshakePacket extends RakNetDataPacket{
	public $cookie;
	public $security;
	public $port;
	public $dataArray0;
	public $dataArray;
	public $timestamp;
	public $session2;
	public $session;

	public function pid(){
		return ProtocolInfo::CLIENT_HANDSHAKE_PACKET;
	}
	
	public function decode(){
		$this->cookie = $this->get(4);
		$this->security = $this->get(1);
		$this->port = $this->getShort(true);
		$this->dataArray0 = $this->get($this->getByte());
		$this->dataArray = $this->getDataArray(9);
		$this->timestamp = $this->get(2);
		$this->session2 = $this->getLong();
		$this->session = $this->getLong();
	}	
	
	public function encode(){
	
	}

}