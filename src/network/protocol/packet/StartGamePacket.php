<?php

class StartGamePacket extends RakNetDataPacket{
	public $seed;
	public $generator;
	public $gamemode;
	public $eid;
	public $x, $y, $z;
	public $spawnX, $spawnY, $spawnZ;
	public function pid(){
		return ProtocolInfo::START_GAME_PACKET;
	}
	
	public function decode(){

	}	
	
	public function encode(){
		$this->reset();
		$this->putInt($this->seed);
		$this->putInt($this->generator);
		$this->putInt($this->gamemode);
		$this->putInt($this->eid);
		$this->putInt($this->spawnX);
		$this->putInt($this->spawnY);
		$this->putInt($this->spawnZ);
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
	}

}
