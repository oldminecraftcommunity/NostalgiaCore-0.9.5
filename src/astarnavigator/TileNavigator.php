<?php

class TileNavigator implements ITileNavigator
{
	private $blockedProvider, $neighborProvider, $distanceAlgorithm, $heuristicAlgorithm;
	public function __construct(IBlockedProvider $blockedProvider, INeighborProvider $neighborProvider, IDistanceAlgorithm $distanceAlgorithm, IDistanceAlgorithm $heuristicAlgorithm){
		$this->blockedProvider = $blockedProvider;
		$this->neighborProvider = $neighborProvider;
		$this->distanceAlgorithm = $distanceAlgorithm;
		$this->heuristicAlgorithm = $heuristicAlgorithm;
	}
	
	public function reconstructPath($path, $current){
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
	
	public function navigate(PathTile $from, PathTile $to, $maxDist)
	{
		$open = new SplPriorityQueue();
		$open->insert($from, 0);
		$path = [];
		$gScore = [];
		$gScore[(string) $from] = 0;
		$has = [(string)$from, true];
		/**
		 * @var array[Tile] $fScore
		 */
		$fScore = [];
		$fScore[(string) $from] = $this->heuristicAlgorithm->calculate($from, $to);
		if($this->blockedProvider->isBlocked($to)){
			return null;
		}
		$visited = [];
		while(!$open->isEmpty())
		{
			$current = $open->top();
			$open->next();
			if ($current == $to){

				return $this->reconstructPath($path, $current);
			}
			foreach($this->neighborProvider->getNeighbors($current) as $neighbor)
			{
				if(!Utils::in_range(Utils::distance($neighbor->asArray(), $from->asArray()), -$maxDist, $maxDist)){
					continue;
				}
				if(isset($visited[(string)$neighbor])){
					continue;
				}
				
				$visited[(string)$neighbor] = $neighbor;
				if ($this->blockedProvider->isBlocked($neighbor))
				{
					continue;
				}
				$distbetweenCost = $this->distanceAlgorithm->calculate($current, $neighbor);
				$tentativeG = $gScore[(string) $current] + $distbetweenCost;
				$tentativeF = $distbetweenCost + $this->heuristicAlgorithm->calculate($neighbor, $to);
				if (!isset($has[(string)$neighbor]))
				{
					$open->insert($neighbor, -$tentativeF);
					$has[(string)$neighbor] = true;
				}
				else if ($tentativeG >= $gScore[(string) $neighbor])
				{
					continue;
				}
				if(!isset($gScore[(string) $neighbor]) || $distbetweenCost < $gScore[(string) $neighbor]){
					$path[(string) $neighbor] = $current;
				}
				
				$gScore[(string) $neighbor] = $tentativeG;
				$fScore[(string) $neighbor] = $tentativeF;
			}
		}
		
		return null;
	}

	
}

