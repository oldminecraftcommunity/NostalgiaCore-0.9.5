<?php

class SandBlock extends FallableBlock{
	public function __construct($meta = 0){
		parent::__construct(SAND, $meta, "Sand");
		$names = [
			0 => "Sand",
			1 => "Red Sand"
		];
		$this->name = $names[$this->meta];
		$this->hardness = 2.5;
	}
	
}