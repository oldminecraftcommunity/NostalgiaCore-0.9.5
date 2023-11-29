<?php

class BiomeDecorator
{
	public function decorate(Level $level, $chunkX, $chunkZ, Random $random){
		return new SmallTreeObject(SaplingBlock::JUNGLE);
	}
}

