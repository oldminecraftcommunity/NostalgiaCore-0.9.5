<?php

class ServerHandshakePacket extends RakNetDataPacket{
	public $port;
	public $session;
	public $session2;

	public function pid(){
		return ProtocolInfo::SERVER_HANDSHAKE_PACKET;
	}
	
	public function decode(){

	}	
	
	public function encode(){
		$this->reset();
		$this->put("\x04\x3f\x57\xfe"); //cookie
		$this->put("\xcd"); //Security flags
		$this->putShort($this->port);
		$this->putDataArray(array(
			"\xf5\xff\xff\xf5",
			"\xff\xff\xff\xff",
			"\xff\xff\xff\xff",
			"\xff\xff\xff\xff",
			"\xff\xff\xff\xff",
			"\xff\xff\xff\xff",
			"\xff\xff\xff\xff",
			"\xff\xff\xff\xff",
			"\xff\xff\xff\xff",
			"\xff\xff\xff\xff",
		));
		$this->put("\x00\x00");
		$this->putLong($this->session);
		$this->putLong($this->session2);
	}

}