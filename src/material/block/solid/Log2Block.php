<?php

class Log2Block extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(LOG2, $meta, "Log2");
		$names = array(
			0 => "Acacia Log",
			1 => "Dark Oak Log",
		);
		$this->name = $names[$this->meta & 0x02];
		$this->hardness = 10;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$faces = array(
			0 => 0,
			1 => 0,
			2 => 0b1000,
			3 => 0b1000,
			4 => 0b0100,
			5 => 0b0100,
		);

		$this->meta = ($this->meta & 0x02) | $faces[$face];
		$this->level->setBlock($block, $this, true, false, true);
		return true;
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, $this->meta & 0x02, 1),
		);
	}
}