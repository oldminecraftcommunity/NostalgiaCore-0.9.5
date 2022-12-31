<?php

class PlayerArmorEquipmentPacket extends RakNetDataPacket{
	public $eid;
	public $slots = array();
	
	public function pid(){
		return ProtocolInfo::PLAYER_ARMOR_EQUIPMENT_PACKET;
	}
	
	public function decode(){
		$this->eid = $this->getInt();		
		$this->slots[0] = $this->getByte();
		$this->slots[1] = $this->getByte();
		$this->slots[2] = $this->getByte();
		$this->slots[3] = $this->getByte();
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putByte($this->slots[0]);
		$this->putByte($this->slots[1]);
		$this->putByte($this->slots[2]);
		$this->putByte($this->slots[3]);
	}

}