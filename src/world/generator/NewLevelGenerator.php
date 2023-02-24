<?php

interface NewLevelGenerator extends LevelGenerator{
	
	public function __construct(array $settings = array());
	
	public function init(Level $level, Random $random);
	
	public function generateChunk($chunkX, $chunkZ);
	
	public function populateChunk($chunkX, $chunkZ);
	
	public function getSettings();
	
	public function populateLevel();
	
	public function getSpawn();
}
