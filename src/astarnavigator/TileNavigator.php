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
	
	public function navigate(PathTile $from, PathTile $to, $maxDist) //TODO optimizations, no arraylist
	{
		$closed = new ArrayList();
		$open = new ArrayList();
		$open->add($from);
		$path = []; //new Dictionary<Tile, Tile>();
		$gScore = []; //new Dictionary<Tile, double>();
		$gScore[(string) $from] = 0;
		/**
		 * @var array[Tile] $fScore
		 */
		$fScore = [];//new Dictionary<Tile, double>();
		$fScore[(string) $from] = $this->heuristicAlgorithm->calculate($from, $to);
		if($this->blockedProvider->isBlocked($to)){
			return null;
		}
		$visited = [];
		while($open->countElements() > 0)
		{
			//sleep(1);
			$open->sortWith(function($k, $k1) use ($fScore){
				return $fScore[(string)$k] === $fScore[(string)$k1] ? 0 : ($fScore[(string)$k] > $fScore[(string)$k1] ? 1 : -1);
			});
			$current = $open->getFirst();
			if ($current->equals($to)){
				return $this->reconstructPath($path, $current);
			}
			$open->remove($current);
			$closed->add($current);
			foreach($this->neighborProvider->getNeighbors($current) as $neighbor)
			{
				
				if(in_array($neighbor, $visited)){
					continue;
				}
				
				$visited[] = $neighbor;
				if ($closed->has($neighbor) || $this->blockedProvider->isBlocked($neighbor))
				{
					continue;
				}
				if(!Utils::in_range(Utils::distance($neighbor->asArray(), $from->asArray()), -$maxDist, $maxDist)){
					continue;
				}
				
				$tentativeG = $gScore[(string) $current] + $this->distanceAlgorithm->calculate($current, $neighbor);
				
				if (!$open->has($neighbor))
				{
					$open->add($neighbor);
				}
				else if ($tentativeG >= $gScore[(string) $neighbor])
				{
					continue;
				}
				$path[(string) $neighbor] = $current;
				$gScore[(string) $neighbor] = $tentativeG;
				$fScore[(string) $neighbor] = $gScore[(string) $neighbor] + $this->heuristicAlgorithm->calculate($neighbor, $to);
			}
		}
		
		return null;
	}

	
}

