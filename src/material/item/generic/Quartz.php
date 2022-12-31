<?php

class QuartzItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(QUARTZ, 0, $count, "Nether Quartz");
	}

}