<?php

class LiquidBlock extends TransparentBlock{
	/**
	 * @param int $id
	 * @param int $meta
	 * @param string $name
	 */
	public function __construct($id, $meta = 0, $name = "Unknown"){
		parent::__construct($id, $meta, $name);
		$this->isLiquid = true;
		$this->breakable = false;
		$this->isReplaceable = true;
		$this->isSolid = false;
		$this->isFullBlock = true;
	}
}