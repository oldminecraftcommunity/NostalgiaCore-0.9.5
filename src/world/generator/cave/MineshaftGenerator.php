<?php

class MineshaftGenerator extends StructureGenerator
{
	protected $spawnChance = 1;//0.01;
	
	public function canSpawnStructureAt($chunkX, $chunkZ)
	{
		$v = $this->rand->nextFloat() < $this->spawnChance && $this->rand->nextInt(80) < max(abs($chunkX), abs($chunkZ));
		if($v) ConsoleAPI::debug("u can spawn mineshaft at $chunkX $chunkZ");
		return $v;
	}

	public function getStructureStart(Level $level, $chunkX, $chunkZ)
	{
		return new StructureMineshaftStart($level, $this->rand, $chunkX, $chunkZ);
	}
}

