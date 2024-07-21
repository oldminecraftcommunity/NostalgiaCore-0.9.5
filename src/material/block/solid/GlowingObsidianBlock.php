<?php

class GlowingObsidianBlock extends SolidBlock implements LightingBlock{
	public static $blockID;
	public function __construct($meta = 0){
		parent::__construct(GLOWING_OBSIDIAN, $meta, "Glowing Obsidian");
	}
	
	public function getMaxLightValue(){
		return 12;
	}
	
}