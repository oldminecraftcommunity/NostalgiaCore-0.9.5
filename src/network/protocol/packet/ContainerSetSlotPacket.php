<?php

class ContainerSetSlotPacket extends RakNetDataPacket{
	public $windowid;
	public $slot;
	public $item;
	
	public function pid(){
		return ProtocolInfo::CONTAINER_SET_SLOT_PACKET;
	}
	
	public function decode(){
		$this->windowid = $this->getByte();
		$this->slot = $this->getShort();
		$this->item = $this->getSlot();
	}
	
	public function encode(){
		$this->reset();
		$this->putByte($this->windowid);
		$this->putShort($this->slot);
		$this->putSlot($this->item);
	}

}