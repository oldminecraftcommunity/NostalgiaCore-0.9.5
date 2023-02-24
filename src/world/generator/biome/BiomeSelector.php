<?php

class BiomeSelector
{
	/** @var Biome */
	private $fallback;
	
	/** @var NoiseGeneratorSimplex */
	private $temperature;
	/** @var NoiseGeneratorSimplex */
	private $rainfall;
	
	/** @var Biome[] */
	private $biomes = [];
	
	private $map;
	
	private $lookup;
	
	public function __construct(Random $random, callable $lookup, Biome $fallback){
		$this->fallback = $fallback;
		$this->lookup = $lookup;
		$this->temperature = new NoiseGeneratorSimplex($random, 2);
		$this->rainfall = new NoiseGeneratorSimplex($random, 2);
	}
	
	public function generateBiomeLookup(){
		$this->map = new SplFixedArray(64 * 64);
		for($t = 0; $t < 64; ++$t){
			for($r = 0; $r < 64; ++$r){
				$this->map[$t + $r << 6] = call_user_func($this->lookup, $t / 63, $r / 63);
			}
		}
	}
	public function getTemperature($x, $z){ //TODO cache
		return ($this->temperature->noise2D($x, $z, 1 / 16, 1 / 512, true) + 1) / 2;
	}
	
	public function getRainfall($x, $z){
		return ($this->rainfall->noise2D($x, $z, 1 / 16, 1 / 512, true) + 1) / 2;
	}
	
	public function getBiome($x, $z){
		$temperature = (int) ($this->getTemperature($x, $z) * 63);
		$rainfall = (int) ($this->getRainfall($x, $z) * 63);
		
		$biomeId = $this->map[$temperature + ($rainfall << 6)];
		return isset($this->biomes[$biomeId]) ? $this->biomes[$biomeId] : $this->fallback;
	}
}

