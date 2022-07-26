<?php

class AddPlayerPacket extends RakNetDataPacket{
	public $clientID;
	public $username;
	public $eid;
	public $x;
	public $y;
	public $z;
	public $pitch;
	public $yaw;
	public $unknown1;
	public $unknown2;
	public $metadata;
	
	public function pid(){
		return ProtocolInfo::ADD_PLAYER_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putLong($this->clientID);
		$this->putString($this->username);
		$this->putInt($this->eid);
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
		$this->putByte($this->yaw);
		$this->putByte($this->pitch);
		$this->putShort($this->unknown1);
		$this->putShort($this->unknown2);
		$this->put(Utils::writeMetadata($this->metadata));
	}

}