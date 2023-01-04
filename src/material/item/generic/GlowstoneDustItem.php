<?php

class GlowstoneDustItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GLOWSTONE_DUST, 0, $count, "Glowstone Dust");
	}

}