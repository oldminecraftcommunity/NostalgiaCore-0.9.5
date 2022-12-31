<?php

class LevelEventPacket extends RakNetDataPacket{
	public $evid;
	public $x;
	public $y;
	public $z;
	public $data;
	
	public function pid(){
		return ProtocolInfo::LEVEL_EVENT_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putShort($this->evid);
		$this->putShort($this->x);
		$this->putShort($this->y);
		$this->putShort($this->z);
		$this->putInt($this->data);
	}

}