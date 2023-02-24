<?php

class SetEntityDataPacket extends RakNetDataPacket{
	public $eid;
	public $metadata;
	
	public function pid(){
		return ProtocolInfo::SET_ENTITY_DATA_PACKET;
	}
	
	public function decode(){
		$this->eid = $this->getInt();
		$b = $this->get(true);
		$this->metadata = Utils::readMetadata($b, true);
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->put(Utils::writeMetadata($this->metadata));
	}

}