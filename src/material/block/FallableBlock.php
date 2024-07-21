<?php

class FallableBlock extends SolidBlock{
	/**
	 * @param int $id
	 * @param int $meta
	 * @param string $name
	 */
	public function __construct($id, $meta = 0, $name = "Unknown"){
		parent::__construct($id, $meta, $name);
		$this->hasPhysics = true;
	}

	/**
	 * @param Item $item
	 * @param Player $player
	 * @param Block $block
	 * @param Block $target
	 * @param int $face
	 * @param int $fx
	 * @param int $fy
	 * @param int $fz
	 *
	 * @return mixed
	 */
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$ret = $this->level->setBlock($this, $this, true, false, true);
		$clz = StaticBlock::getBlock($this->getID());
		$clz::neighborChanged($this->level, $this->x, $this->y, $this->z, 0, 0, 0, 0); //TODO move to another method
		return $ret;
	}
}