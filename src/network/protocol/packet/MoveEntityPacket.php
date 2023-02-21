<?php

class MoveEntityPacket extends RakNetDataPacket{
    /**
     * eid
     * x
     * y
     * z
     * yaw
     * pitch
     * @var array
     */
    public $entities;
	public function pid(){
		return ProtocolInfo::MOVE_ENTITY_PACKET;
	}
	
	public function decode(){

	}
	
	public function encode(){
		$this->reset();
		$this->putInt(count($this->entities));
		foreach($this->entities as $d){
		    $this->putInt($d[0]); //eid
		    $this->putFloat($d[1]); //x
		    $this->putFloat($d[2]); //y
		    $this->putFloat($d[3]); //z
		    $this->putFloat($d[4]); //yaw
		    $this->putFloat($d[5]); //pitch
		}
	}

}