<?php
/*XYZ in Structure String:

|--→x+
|
↓z+
*/
abstract class Structure{
	const MAP_NO_KEY = -255;
	const LEVEL_RSV1 = 1;
	private $structure;
	public $api, $pm;
	public $mapSymToID, $width, $radius;
	
	public function __construct($struct, $width, $symToID = []){
		$this->structure = $struct;
		$this->mapSymToID = $symToID;
		$this->pm = ServerAPI::request();
		$this->api = $this->pm->api;
		$this->width = $width;
		$this->radius = $width / 2;
		
	}
	
	public function addMapping($sym, $id){
		$this->mapSymToID[$sym] = $id;
	}
	public function getMappingFor($sym){
		return isset($this->mapSymToID[$sym]) ? $this->mapSymToID[$sym] : Structure::MAP_NO_KEY;
	}
	
	protected function placeBlock($level, $sym, $tv){
		if($level instanceof Level){
			$idm = $this->getMappingFor($sym);
			if(!isset($idm[1])) $idm[1] = 0;
			if($idm === Structure::MAP_NO_KEY){
				return false;
			}
			$block = $this->api->block->get($idm[0], $idm[1], $tv);
			$level->setBlock($tv, $block, true, false, true);
		}
		
	}
	
	public function build($level, $centerX, $centerY, $centerZ){
		$tempVector = new Vector3(0,0,0);
		$x = $centerX - $this->radius;
		$z = $centerZ - $this->radius;
		foreach($this->structure as $offsetY => $blocksXZ){
			foreach($blocksXZ as $blocks){
				foreach(str_split($blocks) as $block){
					$tempVector->setXYZ($x, $centerY + $offsetY, $z);
					$this->placeBlock($level, $block, $tempVector);
					++$x;
				}
				++$z;
				$x = $centerX - $this->radius;
			}
			$z = $centerZ - $this->radius;	
		}
	}
	
}