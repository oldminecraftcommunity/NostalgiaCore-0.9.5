<?php

class RakNetPacket extends Packet{

	public $packetID;

	public function __construct($packetID){
		$this->packetID = (int) $packetID;
	}

	public function pid(){
		return $this->packetID;
	}

	public function __destruct(){
	}
}