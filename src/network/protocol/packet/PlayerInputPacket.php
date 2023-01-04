<?php
class PlayerInputPacket extends RakNetDataPacket{
	public $unk1, $unk2, $sneaking, $unk4;
	public function encode()
	{
		
	}

	public function pid()
	{
		return ProtocolInfo::PLAYER_INPUT_PACKET;
	}

	public function decode()
	{
		$this->unk1 = $this->getFloat();
		$this->unk2 = $this->getFloat();
		$this->sneaking = bin2hex($this->buffer)[$this->getOffset()] === 4;
		$this->unk4 = bin2hex($this->buffer)[$this->getOffset()+1] === 4;
	}
	
}

