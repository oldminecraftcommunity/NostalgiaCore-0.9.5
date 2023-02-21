<?php

class WoodBlock extends SolidBlock{
	const OAK = 0;
	const SPRUCE = 1;
	const BIRCH = 2;
	const JUNGLE = 3;
	const ACACIA = 4;
	const DARK_OAK = 5;
	
	public function __construct($meta = 0){
		parent::__construct(WOOD, $meta, "Log");
		$names = array(
			WoodBlock::OAK => "Oak Log",
			WoodBlock::SPRUCE => "Spruce Log",
			WoodBlock::BIRCH => "Birch Log",
			WoodBlock::JUNGLE => "Jungle Log",
			WoodBlock::ACACIA => "Acacia Log",
			WoodBlock::DARK_OAK => "Dark Oak Log"
		);
		$this->name = $names[$this->meta & 0x03];
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

		$this->meta = ($this->meta & 0x03) | $faces[$face];
		$this->level->setBlock($block, $this, true, false, true);
		return true;
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, $this->meta & 0x03, 1),
		);
	}
}