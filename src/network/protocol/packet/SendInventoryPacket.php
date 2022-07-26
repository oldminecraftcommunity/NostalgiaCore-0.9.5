<?php

class SendInventoryPacket extends RakNetDataPacket{
	public $eid;
	public $windowid;
	public $slots = array();
	public $armor = array();
	
	public function pid(){
		return ProtocolInfo::SEND_INVENTORY_PACKET;
	}
	
	public function decode(){
		$this->eid = $this->getInt();
		$this->windowid = $this->getByte();
		$count = $this->getShort();
		for($s = 0; $s < $count and !$this->feof(); ++$s){
			$this->slots[$s] = $this->getSlot();
		}
		if($this->windowid === 1){ //Armor is sent
			for($s = 0; $s < 4; ++$s){
				$this->armor[$s] = $this->getSlot();
			}
		}
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putByte($this->windowid);
		$this->putShort(count($this->slots));
		foreach($this->slots as $slot){
			$this->putSlot($slot);
		}
		if($this->windowid === 1 and count($this->armor) === 4){
			for($s = 0; $s < 4; ++$s){
				$this->putSlot($this->armor[$s]);
			}
		}
	}

}