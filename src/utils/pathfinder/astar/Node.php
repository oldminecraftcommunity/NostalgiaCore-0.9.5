<?php
/*
 MIT License
 Copyright (c) 2014 Peter Petermann
 
 Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:
 
 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE.
 */


abstract class Node extends Vector3
{
    /**
     * @var Node|bool
     */
    protected $parent = false;
    
    /**
     * @var int|float
     */
    protected $gCost;
    
    /**
     * @param Node $parent
     */
    public function setParent(Node $parent)
    {
        $this->parent = $parent;
    }
    
    /**
     * @return Node|bool
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    public function getParentAndCleanSelf(){
        try{
            return $this->parent;
        }finally{
            $this->parent = null;
        }
    }
    
    /**
     * @return int|float
     */
    public function getGCost()
    {
        if(is_null($this->gCost)) {
            $this->gCost =
            $this->parent ? $this->parent->getGCost() + $this->getOwnCost() : $this->getOwnCost();
        }
        
        return $this->gCost;
    }
    
    /**
     * @param Node $target
     * @return float|int
     */
    public function getFCost(Node $target)
    {
        return $this->getGCost() + $this->getHCost($target);
    }
    
    /**
     * @return int|float
     */
    abstract public function getOwnCost();
    
    /**
     * @param Node $target
     * @return int|float
     */
    abstract public function getHCost(Node $target);
    
    /**
     * @param AStar $pf
     * @return Node[]
     */
    abstract public function getAdjacentNodes(AStar $pf);
    
    /**
     * @param Node $compareTo
     * @return bool
     */
    abstract public function equals(Node $compareTo);
    
    /**
     * Check can this point be used
     * @param AStar $pf
     * @return bool
     */
    abstract public function canMoveHere(AStar $pf);
    
    /**
     * should return a unique string for this
     *
     * @return string
     */
    public function __toString(){
        return parent::__toString();
    }
    
    /**
     * this method should allow a node
     * to get the data from the target node getHostCost requires for its heuristic (if needed)
     *
     * @return array
     */
    public function getDataForH()
    {
        return [];
    }
}