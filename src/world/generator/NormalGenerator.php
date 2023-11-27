<?php
/***REM_START***/
require_once("NewLevelGenerator.php");
/***REM_END***/

class NormalGenerator implements NewLevelGenerator{
	
	private $populators = array();
	private $level;
	private $random;
	private $worldHeight = 65;
	private $waterHeight = 63;
	private $noiseHills;
	private $noisePatches;
	private $noisePatchesSmall;
	private $noiseBase;
	
	public function __construct(array $options = array()){
		
	}
	
	public function getSettings(){
		return array();
	}
	
	public function init(Level $level, Random $random){
		$this->level = $level;
		$this->random = $random;
		$this->random->setSeed($this->level->getSeed());
		$this->noiseHills = new NoiseGeneratorPerlin($this->random, 3);
		$this->noisePatches = new NoiseGeneratorPerlin($this->random, 2);
		$this->noisePatchesSmall = new NoiseGeneratorPerlin($this->random, 2);
		$this->noiseBase = new NoiseGeneratorPerlin($this->random, 16);
		
		$ores = new OrePopulator();
		$ores->setOreTypes(array(
			new OreType(new CoalOreBlock(), 20, 16, 0, 128),
			new OreType(New IronOreBlock(), 20, 8, 0, 64),
			new OreType(new RedstoneOreBlock(), 8, 7, 0, 16),
			new OreType(new LapisOreBlock(), 1, 6, 0, 32),
			new OreType(new GoldOreBlock(), 2, 8, 0, 32),
			new OreType(new DiamondOreBlock(), 1, 7, 0, 16),
			new OreType(new EmeraldOreBlock(), 1, 2, 0, 16), //TODO vanilla

			new OreType(new DirtBlock(), 20, 32, 0, 128),
			new OreType(new GravelBlock(), 10, 16, 0, 128),
			new OreType(new StoneBlock(1), 12, 16, 0, 128),
			new OreType(new StoneBlock(3), 12, 16, 0, 128),
			new OreType(new StoneBlock(5), 12, 16, 0, 128),
		));
		$this->populators[] = $ores;
		
		$trees = new TreePopulator();
		$trees->setBaseAmount(3);
		$trees->setRandomAmount(0);
		$this->populators[] = $trees;
		
		$tallGrass = new TallGrassPopulator();
		$tallGrass->setBaseAmount(5);
		$tallGrass->setRandomAmount(0);
		$this->populators[] = $tallGrass;
	}
	
	public function generateChunk($chunkX, $chunkZ){
		$this->random->setSeed(0xdeadbeef ^ ($chunkX << 8) ^ $chunkZ ^ $this->level->getSeed());
		$hills = array();
		$base = array();
		for($z = 0; $z < 16; ++$z){
			for($x = 0; $x < 16; ++$x){
				$i = ($z << 4) + $x;
				$hills[$i] = $this->noiseHills->noise3D($x + ($chunkX << 4), 0, $z + ($chunkZ << 4), 0.11, 12, true);
				$patches[$i] = $this->noisePatches->noise2D($x + ($chunkX << 4), $z + ($chunkZ << 4), 0.03, 16, true);
				//$patchesSmall[$i] = $this->noisePatchesSmall->noise2D($x + ($chunkX << 4), $z + ($chunkZ << 4), 0.5, 4, true);
				$base[$i] = $this->noiseBase->noise2D($x + ($chunkX << 4), $z + ($chunkZ << 4), 0.7, 16, true);
				if($base[$i] < 0){
					$base[$i] *= 0.5;
				}
			}
		}
		for($chunkY = 0; $chunkY < 8; ++$chunkY){
			$chunk = "";
			$startY = $chunkY << 4;
			$endY = $startY + 16;
			for($z = 0; $z < 16; ++$z){
				for($x = 0; $x < 16; ++$x){
					$i = ($z << 4) + $x;
					$height = $this->worldHeight + $hills[$i] * 14 + $base[$i] * 7;
					$height = (int) $height;
					
					for($y = $startY; $y < $endY; ++$y){
						$diff = $height - $y;
						if($y <= 4 and ($y === 0 or $this->random->nextFloat() < 0.33)){
							$chunk .= "\x07"; //bedrock
						}elseif($diff > 2){
							$chunk .= "\x01"; //stone
						}elseif($diff > 0){
							if($patches[$i] > 0.9){
								$chunk .= "\x01"; //stone
							}elseif($patches[$i] < -0.8){
								$chunk .= "\x0d"; //gravel
							}else{
								$chunk .= "\x03"; //dirt
							}
						}elseif($y <= $this->waterHeight){
							if(($this->waterHeight - $y) <= 1 and $diff === 0){
								$chunk .= "\x0c"; //sand
							}elseif($diff === 0){
								/*if($patchesSmall[$i] > 0.3){
									$chunk .= "\x0d"; //gravel
								}elseif($patchesSmall[$i] < -0.45){
									$chunk .= "\x0c"; //sand
								}else{*/
									$chunk .= "\x03"; //dirt
								//}
							}else{
								$chunk .= "\x09"; //still_water
							}
						}elseif($diff === 0){
							if($patches[$i] > 0.7){
								$chunk .= "\x01"; //stone
							}elseif($patches[$i] < -0.8){
								$chunk .= "\x0d"; //gravel
							}else{
								$chunk .= "\x02"; //grass
							}
						}else{
							$chunk .= "\x00";
						}
					}
					$chunk .= "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"; //meta
					$chunk .= "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"; //light/skylight
					$chunk .= "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"; //skylight/light
				}
			}
			$this->level->level->setBiomeIdArrayForChunk($chunkX, $chunkZ, str_repeat(chr(BIOME_PLAINS), 256));
			$this->level->setMiniChunk($chunkX, $chunkZ, $chunkY, $chunk);
		}
	}
	
	public function populateChunk($chunkX, $chunkZ){
		$this->level->level->setPopulated($chunkX, $chunkZ, true);
		$this->random->setSeed(0xdeadbeef ^ ($chunkX << 8) ^ $chunkZ ^ $this->level->getSeed());
		foreach($this->populators as $populator){
			$this->random->setSeed(0xdeadbeef ^ ($chunkX << 8) ^ $chunkZ ^ $this->level->getSeed());
			$populator->populate($this->level, $chunkX, $chunkZ, $this->random);
		}
	}
	
	public function getSpawn(){
		return $this->level->getSafeSpawn(new Vector3(127.5, 128, 127.5));
	}
	public function populateLevel()
	{}

	
}
