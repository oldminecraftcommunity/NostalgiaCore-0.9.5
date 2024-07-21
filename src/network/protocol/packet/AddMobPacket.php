<?php

class AddMobPacket extends RakNetDataPacket{
	public $eid;
	public $type;
	public $x;
	public $y;
	public $z;
	public $pitch;
	public $yaw;
	public $metadata;
	
	public function pid(){
		return ProtocolInfo::ADD_MOB_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putInt($this->type);
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
		$this->putByte($this->yaw);
		$this->putByte($this->pitch);
		$this->put(Utils::writeMetadata($this->metadata));
	}

}