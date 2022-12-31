<?php

class SolidBlock extends GenericBlock{
	/**
	 * @param int $id
	 * @param int $meta
	 * @param string $name
	 */
	public function __construct($id, $meta = 0, $name = "Unknown"){
		parent::__construct($id, $meta, $name);
		$this->isSolid = true;
		$this->isFullBlock = true;
	}
}