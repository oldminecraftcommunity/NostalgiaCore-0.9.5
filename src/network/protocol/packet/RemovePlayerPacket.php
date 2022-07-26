<?php

class RemovePlayerPacket extends RakNetDataPacket{
	public $eid;
	public $clientID;
	
	public function pid(){
		return ProtocolInfo::REMOVE_PLAYER_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putLong($this->clientID);
	}

}