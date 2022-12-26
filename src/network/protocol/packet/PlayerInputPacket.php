<?php
class PlayerInputPacket extends RakNetDataPacket{
	public $unk1, $unk2, $unk3, $unk4;
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
		$this->unk3 = $this->getByte();
		$this->unk4 = $this->getByte();
	}
	
}

