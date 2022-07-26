<?php

class GoldenHelmetItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_HELMET, $meta, $count, "Golden Helmet");
	}
}