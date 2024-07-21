<?php

class BookshelfBlock extends SolidBlock{
	public static $blockID;
	public function __construct(){
		parent::__construct(BOOKSHELF, 0, "Bookshelf");
		$this->hardness = 7.5;
	}
	
}