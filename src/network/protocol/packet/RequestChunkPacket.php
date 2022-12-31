<?php

class RequestChunkPacket extends RakNetDataPacket{
	public $chunkX;
	public $chunkZ;
	
	public function pid(){
		return ProtocolInfo::REQUEST_CHUNK_PACKET;
	}
	
	public function decode(){
		$this->chunkX = $this->getInt();
		$this->chunkZ = $this->getInt();
	}
	
	public function encode(){

	}

}