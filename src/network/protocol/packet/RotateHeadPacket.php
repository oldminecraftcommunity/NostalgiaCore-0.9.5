<?php

class RotateHeadPacket extends RakNetDataPacket{
	public $eid;
	public $yaw;
	/**
	 * Should yaw be modifed<br>
	 * false = <b>yaw  / 360 / 0.0039062</b><br>
	 * true = <b>yaw</b>
	 * @var boolean
	 */
	public $rawYaw = false;
	public function pid(){
		return ProtocolInfo::ROTATE_HEAD_PACKET;
	}
	
	public function decode(){
		
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		@$this->putByte($this->rawYaw ? $this->yaw : $this->yaw / 360 / 0.0039062); //dont ask me why does chr count float TODO find a better way
	}

}