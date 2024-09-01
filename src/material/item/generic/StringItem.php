<?php

class StringItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STRING, $meta, $count, "String");
	}
}