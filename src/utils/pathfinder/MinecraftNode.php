<?php

class MinecraftNode extends Node
{
    public $nodes = null;
    
    /**
     * {@inheritDoc}
     * @see Node::__toString()
     */
    public function __construct($x, $y, $z){
        parent::__construct($x, $y, $z);
    }
    
    public function __toString()
    {
        return "MinecraftNode({$this->x}, {$this->y}, {$this->z})";
    }
    public function add($x = 0, $y = 0, $z = 0){
        return new MinecraftNode($x+$this->x, $y+$this->y, $z+$this->z);
    }
    /**
     * {@inheritDoc}
     * @see Node::getOwnCost()
     */
    public function getOwnCost()
    {
        return 1;
    }
    
    public function getParentAndCleanSelf(){
        try{
            return $this->parent;
        }finally{
            $this->parent = null;
            $this->nodes = null;
        }
    }
    
    public function generateAdjNodes(AStar $pf)
    {
        $this->nodes = [];
        for($x = -1; $x <= 1; $x++){
            for($z = -1; $z <= 1; $z++){
                $node = new MinecraftNode($x + $this->x, $this->y, $z + $this->z);
                if(!$node->canMoveHere($pf)){
                    //console("[DEBUG] Obstacle at $node");
                    continue;
                }
                $this->nodes[] = $node;
            }
        }
    }
    
    /**
     * {@inheritDoc}
     * @see Node::getAdjacentNodes()
     */
    public function getAdjacentNodes(AStar $pf)
    {
        if($this->nodes === null){
            $this->generateAdjNodes($pf);
        }
        return $this->nodes;
    }
    
    /**
     * {@inheritDoc}
     * @see Node::equals()
     */
    public function equals(Node $node)
    {
        return $node->x === $this->x && $this->z === $node->z;
    }
    
    
    /**
     * {@inheritDoc}
     * @see Node::getHCost()
     */
    public function getHCost(Node $target)
    {
        return abs($target->x - $this->x) + abs($target->z - $this->z);
    }
    
    /**
     * {@inheritDoc}
     * @see Node::canMoveHere()
     */
    
    public function canMoveHere(AStar $pf)
    {
        return !$pf->entity->level->getBlockWithoutVector($this->x, $this->y, $this->z)->isSolid;
    }


}

