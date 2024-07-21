<?php
class TileNavigator
{
	
	const OFFSETS = [
		[0, 0, 1],
		[0, 0, -1],
		[1, 0, 0],
		[-1, 0, 0],
	];
	
	public static $pathfinderAccessed = 0;
	public $entity;
	public $avoidFallDamage = true;
	public $tall = false;
	public function __construct(Living $entity){
		$this->entity = $entity;
		$this->tall = $entity->height > 1;
	}
	
	public function reconstructPath($path, $current){
		console("path built");
		$totalPath = [$current];
		while (isset($path[(string)$current]))
		{
			$current = $path[(string)$current];
			$totalPath[] = $current;
		}
		//foreach(array_unique($path) as $k => $p) console($k.":".$p);
		//foreach($totalPath as $k => $p) console($k.":".$p);
		array_pop($totalPath);
		return array_reverse($totalPath);
	}

	public function isLocBlocked(PMFLevel $level, $loc){
		
		$chunkX = $loc >> 20 & 0xf;
		$chunkZ = $loc >> 12 & 0xf;
		$chunkY = $loc >> 4 & 0xf;
		
		$index = $chunkZ << 4 | $chunkX;
		
		$blockX = $loc >> 16 & 0xf;
		$blockZ = $loc >> 8 & 0xf;
		$blockY = $loc & 0xf;
		
		$id = $level->fastGetBlockID($chunkX, $chunkY, $chunkZ, $blockX, $blockY, $blockZ, $index);
		$b = StaticBlock::getIsSolid($id);
		if($this->tall){
			$loc += 1;
			$chunkY = $loc >> 4 & 0xf;
			$blockY = $loc & 0xf;
			$id = $level->fastGetBlockID($chunkX, $chunkY, $chunkZ, $blockX, $blockY, $blockZ, $index);
			return $b || StaticBlock::getIsSolid($id);
		}
		
		return $b;
	}
	
	
	public function navigate(Level $level, $fromX, $fromY, $fromZ, $toX, $toY, $toZ, $maxDist)
	{
		$from = $fromX << 16 | $fromZ << 8 | $fromY;
		$to = $toX << 16 | $toZ << 8 | $toY;
		
		$pmfLevel = $level->level;
		
		$open = new SplPriorityQueue();
		//$open->insert(, 0);
		$open->insert($from, 0);
		$path = [];
		$gScore = [];
		$gScore[(string) $from] = 0;
		$has = [(string)$from, true];
		if($this->isLocBlocked($pmfLevel, $to)){
			return null;
		}
		$visited = [];
		$maxDist*=$maxDist; //no square root
		$closestToTarget = null;
		$closestToTargetDist = INF;
		
		while(!$open->isEmpty())
		{
			$current = $open->top();
			$currentX = $current >> 16 & 0xff;
			$currentY = $current & 0xff;
			$currentZ = $current >> 8 & 0xff;
			$open->next();
			if ($current == $to){
				return $this->reconstructPath($path, $current);
			}
			
			$points = [];
			foreach(self::OFFSETS as $offset){
				$newX = $offset[0] + $currentX;
				$newY = $offset[1] + $currentY;
				$newZ = $offset[2] + $currentZ;
				if($newX < 0 || $newX > 255 || $newY < 0 || $newY > 255 || $newZ < 0 || $newZ > 255) continue;
				$new = $newX << 16 | $newZ << 8 | $newY;
				
				if(!$this->isLocBlocked($pmfLevel, $new)){
					if($newY > 0 && !$this->isLocBlocked($pmfLevel, $new - 1)){
						if(!$this->avoidFallDamage){
							$new -= 1;
							$newY -= 1;
						}else{
							if($this->isLocBlocked($pmfLevel, $new - 2)){
								$new -= 1;
								$newY -= 1;
							}else if($this->isLocBlocked($pmfLevel, $new - 3)){
								$new -= 2;
								$newY -= 2;
							}else if($this->isLocBlocked($pmfLevel, $new - 4)){
								$new -= 3;
								$newY -= 3;
							}else{
								continue;	
							}
						}
					}
					$dist = ($fromX - $newX)*($fromX - $newX) + ($fromY - $newY)*($fromY - $newY) + ($fromZ - $newZ)*($fromZ - $newZ);
					if($dist < -$maxDist || $dist > $maxDist){
						continue;
					}
					
					$points[] = $new;
				}else if(!$this->isLocBlocked($pmfLevel, $current+1) && !$this->isLocBlocked($pmfLevel, $new+1)){
					$new += 1;
					$newY += 1;
					
					$dist = ($fromX - $newX)*($fromX - $newX) + ($fromY - $newY)*($fromY - $newY) + ($fromZ - $newZ)*($fromZ - $newZ);
					if($dist < -$maxDist || $dist > $maxDist){
						continue;
					}
					
					$points[] = $new;
				}
			}
			
			foreach($points as $neighbor)
			{
				if(isset($visited[$neighbor])){
					continue;
				}
				$visited[$neighbor] = true;
				
				$diffX = ($toX - ($neighbor >> 16 & 0xff));
				$diffY = ($toY - ($neighbor & 0xff));
				$diffZ = ($toZ - ($neighbor >> 8 & 0xff));
				$targetDist = $diffX*$diffX + $diffY*$diffY + $diffZ*$diffZ;
				
				
				$diffX = ($currentX - ($neighbor >> 16 & 0xff));
				$diffY = ($currentY - ($neighbor & 0xff));
				$diffZ = ($currentZ - ($neighbor >> 8 & 0xff));
				
				$distbetweenCost = $diffX*$diffX + $diffY*$diffY + $diffZ*$diffZ;
				$tentativeG = $gScore[$current] + $distbetweenCost;
				if (!isset($has[$neighbor]))
				{ 
					//if(isset($open[-$tentativeG])) console("overwriting $tentativeG");
					//$open[-$tentativeG] = $neighbor;
					
					$open->insert($neighbor, -$tentativeG);
					$has[$neighbor] = true;
				}
				elseif ($tentativeG >= $gScore[$neighbor])
				{
					continue;
				}
				if(!isset($gScore[$neighbor]) || $distbetweenCost < $gScore[$neighbor]){
					$path[$neighbor] = $current;
					
					if($targetDist < $closestToTargetDist){
						//console("found new best to target: $neighbor($closestToTargetDist -> $targetDist)");
						
						$closestToTarget = $neighbor;
						$closestToTargetDist = $targetDist;						
					}
				}
				
				$gScore[$neighbor] = $tentativeG;
			}
		}
		
		if($closestToTarget != null){
			return $this->reconstructPath($path, $closestToTarget);
		}
		
		return null;
	}

	
}

