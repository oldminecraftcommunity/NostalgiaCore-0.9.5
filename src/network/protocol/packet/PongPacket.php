<?php

class PongPacket extends RakNetDataPacket{
	public $time = 0;
	public $ptime = 0;

	public function pid(){
		return ProtocolInfo::PONG_PACKET;
	}
	
	public function decode(){
		$this->ptime = $this->getLong();
		$this->time = $this->getLong();
	}	
	
	public function encode(){
		$this->reset();
		$this->putLong($this->ptime);
		$this->putLong($this->time);
	}

}