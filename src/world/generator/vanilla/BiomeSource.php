<?php

class BiomeSource
{
	/**
	 * @var NoiseGeneratorOctaves $temperatureNoise
	 * @var NoiseGeneratorOctaves $rainfallNoise
	 * @var NoiseGeneratorOctaves $detailNoise
	 */
	public $temperatureNoise, $rainfallNoise, $detailNoise;
	/**
	 * 
	 * @var float[] $tempNoises
	 * @var float[] $rainfallNoises
	 * @var float[] $detailNoises
	 */
	public $temperatureNoises, $rainfallNoises, $detailNoises;
	public function __construct(Level $level){
		$this->temperatureNoise = new NoiseGeneratorOctaves(new MTRandom($level->getSeed() * 9871), 4);
		$this->rainfallNoise = new NoiseGeneratorOctaves(new MTRandom($level->getSeed() * 39811), 4);
		$this->detailNoise = new NoiseGeneratorOctaves(new MTRandom($level->getSeed() * 543321), 2);
	}
	
	public function getBiome($x, $z){
		return $this->getBiomeBlock($x, $z, 1, 1)[0];
	}
	
	public function getTemperatureBlock($x, $z, $xSize, $zSize){
		$this->temperatureNoises = $this->temperatureNoise->generateNoiseOctaves($x, $z, $xSize, $zSize, 0.025, 0.025, 0.25);
		$this->detailNoises = $this->detailNoise->generateNoiseOctaves($x, $z, $xSize, $zSize, 0.25, 0.25, 0.588);
		
		$index = 0;
		
		for($blockX = 0; $blockX < $xSize; ++$blockX){
			for($blockZ = 0; $blockZ < $zSize; ++$blockZ){
				//float f = 1.0f - ((((this.detailNoises[index] * 1.1f) + 0.5f) * 0.01f) + (((this.temperatureNoises[index] * 0.15f) + 0.7f) * 0.99f));
				//float f1 = 1.0f - (f*f);
				$f = 1 - (((($this->detailNoises[$index] * 1.1) + 0.5) * 0.01) + ((($this->temperatureNoises[$index] * 0.15) + 0.7) * 0.99));
				$f1 = 1 - ($f*$f);
				if($f1 < 0) $f1 = 0;
				elseif($f1 > 1) $f1 = 1;
				
				$this->temperatureNoises[$index++] = $f1;
			}
		}
		
		return $this->temperatureNoises;

	}
	
	
	public function getBiomeBlock($x, $z, $xSize, $zSize){
		$this->temperatureNoises = $this->temperatureNoise->generateNoiseOctaves($x, $z, $xSize, $zSize, 0.025, 0.025, 0.25);
		$this->rainfallNoises = $this->rainfallNoise->generateNoiseOctaves($x, $z, $xSize, $zSize, 0.05, 0.05, 0.3333);
		$this->detailNoises = $this->detailNoise->generateNoiseOctaves($x, $z, $xSize, $zSize, 0.25, 0.25, 0.588);
		
		$localBiomeArray = [];
		$index = 0;
		
		for($blockX = 0; $blockX < $xSize; ++$blockX){
			for($blockZ = 0; $blockZ < $zSize; ++$blockZ){
				$rain = ((($this->detailNoises[$index] * 1.1) + 0.5) * 0.002) + ((($this->rainfallNoises[$index] * 0.15) + 0.5) * 0.998);
				$f1 = 1 - ((((($this->detailNoises[$index]) * 1.1) + 0.5) * 0.01) + ((($this->temperatureNoises[$index] * 0.15) + 0.7) * 0.99));
				$blockTemp = 1 - ($f1 * $f1);
				
				if($blockTemp < 0) $blockTemp = 0;
				elseif($blockTemp > 1) $blockTemp = 1;
				
				if($rain < 0) $rain = 0;
				elseif($rain > 1) $rain = 1;
				
				$this->temperatureNoises[$index] = $blockTemp;
				$this->rainfallNoises[$index] = $rain;
				$localBiomeArray[$index++] = Biome::getBiome($blockTemp, $rain);
			}
		}
		
		return $localBiomeArray;
	}
}

