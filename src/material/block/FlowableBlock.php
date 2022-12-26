<?php

class FlowableBlock extends TransparentBlock{
	/**
	 * @param int $id
	 * @param int $meta
	 * @param string $name
	 */
	public function __construct($id, $meta = 0, $name = "Unknown"){
		parent::__construct($id, $meta, $name);
		$this->isFlowable = true;
		$this->isFullBlock = false;
		$this->isSolid = false;
	}
}