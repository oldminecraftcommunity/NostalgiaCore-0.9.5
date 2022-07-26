<?php

class RotateHeadPacket extends RakNetDataPacket{
	public $eid;
	public $yaw;
	
	public function pid(){
		return ProtocolInfo::ROTATE_HEAD_PACKET;
	}
	
	public function decode(){
		
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putByte($this->yaw);
	}

}