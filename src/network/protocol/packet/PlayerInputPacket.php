<?php
class PlayerInputPacket extends RakNetDataPacket{
	public $moveStrafe, $moveForward, $isJumping, $isSneaking;
	public function encode()
	{
		
	}

	public function pid()
	{
		return ProtocolInfo::PLAYER_INPUT_PACKET;
	}

	public function decode()
	{
		$this->moveStrafe = $this->getFloat();
		$this->moveForward = $this->getFloat();
		$this->isJumping = $this->getByte() != 0;
		$this->isSneaking = $this->getByte() != 0;
	}
	
}

