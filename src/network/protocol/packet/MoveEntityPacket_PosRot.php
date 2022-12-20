<?php

class MoveEntityPacket_PosRot extends RakNetDataPacket{
	public $eid;
	public $x;
	public $y;
	public $z;
	public $yaw;
	public $pitch;
	
	public function pid(){
		return ProtocolInfo::MOVE_ENTITY_PACKET_POSROT;
	}
	
	public function decode(){
		$this->get(7);
		$this->eid = $this->getInt();
		$this->x = $this->getFloat();
		$this->y = $this->getFloat();
		$this->z = $this->getFloat();
		$this->yaw = $this->getFloat();
		$this->pitch = $this->getFloat();
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
		$this->putFloat($this->yaw);
		$this->putFloat($this->pitch);
	}

}