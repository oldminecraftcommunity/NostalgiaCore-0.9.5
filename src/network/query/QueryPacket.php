<?php

class QueryPacket extends Packet{

	const HANDSHAKE = 9;
	const STATISTICS = 0;

	public $packetType;
	public $sessionID;
	public $payload;

	public function decode(){
		$this->packetType = ord($this->buffer[2]);
		$this->sessionID = Utils::readInt(substr($this->buffer, 3, 4));
		$this->payload = substr($this->buffer, 7);
	}

	public function encode(){
		$this->buffer .= chr($this->packetType);
		$this->buffer .= Utils::writeInt($this->sessionID);
		$this->buffer .= $this->payload;
	}
}