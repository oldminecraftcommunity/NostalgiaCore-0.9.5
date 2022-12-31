<?php

class AddPaintingPacket extends RakNetDataPacket{
	public $eid;
	public $x;
	public $y;
	public $z;
	public $direction;
	public $title;
	
	public function pid(){
		return ProtocolInfo::ADD_PAINTING_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putInt($this->x);
		$this->putInt($this->y);
		$this->putInt($this->z);
		$this->putInt($this->direction);
		$this->putString($this->title);
	}

}