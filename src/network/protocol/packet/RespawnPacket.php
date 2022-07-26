<?php

class RespawnPacket extends RakNetDataPacket{
	public $eid;
	public $x;
	public $y;
	public $z;
	
	public function pid(){
		return ProtocolInfo::RESPAWN_PACKET;
	}
	
	public function decode(){
		$this->eid = $this->getInt();
		$this->x = $this->getFloat();
		$this->y = $this->getFloat();
		$this->z = $this->getFloat();
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
	}

}