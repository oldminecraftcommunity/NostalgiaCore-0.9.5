<?php

class RemoveBlockPacket extends RakNetDataPacket{
	public $eid;
	public $x;
	public $y;
	public $z;
	
	public function pid(){
		return ProtocolInfo::REMOVE_BLOCK_PACKET;
	}
	
	public function decode(){
		$this->eid = $this->getInt();
		$this->x = $this->getInt();
		$this->z = $this->getInt();
		$this->y = $this->getByte();
	}
	
	public function encode(){

	}

}