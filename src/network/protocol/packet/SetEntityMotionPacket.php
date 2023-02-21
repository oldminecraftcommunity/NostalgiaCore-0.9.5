<?php

class SetEntityMotionPacket extends RakNetDataPacket{
	public $entities;
	
	public function pid(){
		return ProtocolInfo::SET_ENTITY_MOTION_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt(count($this->entities));
		foreach($this->entities as $d){
			$this->putInt($d[0]);
			$this->putShort((int) ($d[1]*8000));
			$this->putShort((int) ($d[2]*8000));
			$this->putShort((int) ($d[3]*8000));
		}
	}

}
