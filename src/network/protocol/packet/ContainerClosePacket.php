<?php

class ContainerClosePacket extends RakNetDataPacket{
	public $windowid;
	
	public function pid(){
		return ProtocolInfo::CONTAINER_CLOSE_PACKET;
	}
	
	public function decode(){
		$this->windowid = $this->getByte();
	}
	
	public function encode(){
		$this->reset();
		$this->putByte($this->windowid);
	}

}