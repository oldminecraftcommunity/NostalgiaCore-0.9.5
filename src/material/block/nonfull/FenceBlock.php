<?php

class FenceBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(FENCE, $meta, "Fence");
		if(PocketMinecraftServer::$is0105){
			$names = [
				0 => "Oak Fence",
				1 => "Spruce Fence",
				2 => "Birch Fence",
				3 => "Jungle Fence",
				4 => "Acacia Fence",
				5 => "Dark Oak Fence"
			];
			$this->name = $names[$this->meta & 0x07];
		}
		$this->isFullBlock = false;
		$this->hardness = 15;
	}
}
