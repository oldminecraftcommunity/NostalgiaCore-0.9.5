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
	public static $biomes = [];
	
	private $map = [];
	
	private $lookup;
	
	public function __construct(Random $random, Biome $fallback){
		$this->fallback = $fallback;
		$this->temperature = new NoiseGeneratorSimplex($random, 2);
		$this->rainfall = new NoiseGeneratorSimplex($random, 2);
		$this->generateBiomeLookup();
	}
	
	public static function registerBiome(Biome $b){
		ConsoleAPI::debug("Registered $b");
		self::$biomes[$b->getID()] = $b;
	}
	
	public function generateBiomeLookup(){
		for($t = 0; $t < 64; ++$t){
			for($r = 0; $r < 64; ++$r){
				$this->map[$t + ($r << 6)] = $this->getBiomeTR($t / 63, $r / 63);
			}
		}
	}

	public function getBiomeTR($t, $r){
		if($r < 0.60){
			return BIOME_PLAINS;
		}else{
			if($t < 0.70){
				return BIOME_EXTREME_HILLS;
			}
		}
	}
	
	public function getTemperature($x, $z){ //TODO cache
		return ($this->temperature->noise2D($x * (1/512), $z * (1/512), 2, 1 / 16, true) + 1) / 2;
	}
	
	public function getRainfall($x, $z){
		return ($this->rainfall->noise2D($x * (1/512), $z * (1/512), 2, 1 / 16, true) + 1) / 2;
	}
	
	public function pickBiome($x, $z){
		$temperature = (int) ($this->getTemperature($x, $z) * 63);
		$rainfall = (int) ($this->getRainfall($x, $z) * 63);

		$biomeId = nullsafe($this->map[$temperature + ($rainfall << 6)], -1);
		return nullsafe(self::$biomes[$biomeId], $this->fallback);
	}
}

