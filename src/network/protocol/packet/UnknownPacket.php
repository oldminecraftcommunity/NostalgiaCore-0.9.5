<?php

class UnknownPacket extends RakNetDataPacket{
	public $packetID = -1;
	
	public function pid(){
		return $this->packetID;
	}
	
	public function decode(){

	}
	
	public function encode(){

	}

}