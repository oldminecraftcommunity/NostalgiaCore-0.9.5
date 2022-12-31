<?php

class PlayerEquipmentPacket extends RakNetDataPacket{
	public $eid;
	public $item;
	public $meta;
	public $slot;
	
	public function pid(){
		return ProtocolInfo::PLAYER_EQUIPMENT_PACKET;
	}
	
	public function decode(){
		$this->eid = $this->getInt();
		$this->item = $this->getShort();
		$this->meta = $this->getShort();
		$this->slot = $this->getByte();
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putShort($this->item);
		$this->putShort($this->meta);
		$this->putByte($this->slot);
	}

}