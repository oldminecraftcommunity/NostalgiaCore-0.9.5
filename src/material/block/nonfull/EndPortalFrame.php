<?php

class EndPortalFrameBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(END_PORTAL_FRAME, $meta, "End Portal Frame");
		$this->isFullBlock = false;
		$this->hardness = 3600000;
        //direction is isset in this version?
	}
}