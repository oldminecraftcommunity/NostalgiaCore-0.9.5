<?php

class UpdateBlockPacket extends RakNetDataPacket{
	public $x;
	public $z;
	public $y;
	public $block;
	public $meta;
	
	public function pid(){
		return ProtocolInfo::UPDATE_BLOCK_PACKET;
	}
	
	public function decode(){
		$this->x = $this->getInt();
		$this->z = $this->getInt();
		$this->y = $this->getByte();
		$this->block = $this->getByte();
		$this->meta = $this->getByte();
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->x);
		$this->putInt($this->z);
		$this->putByte($this->y);
		$this->putByte($this->block);
		$this->putByte($this->meta);
	}

}