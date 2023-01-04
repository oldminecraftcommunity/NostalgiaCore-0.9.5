<?php

class PaperItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(PAPER, 0, $count, "Paper");
	}

}