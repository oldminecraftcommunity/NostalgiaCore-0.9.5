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

/**
 * Class AStar
 *
 */
class AStar
{
    /**
     * @var Node[]
     */
    protected $open = [];
    
    /**
     * @var string[]
     */
    protected $closed = [];
    /**
     * @var Entity
     */
    public $entity;
    
    public function __construct(&$entity){
        $this->entity = $entity;
    }
    
    /**
     * find a path from Node $start to Node $end
     * @param Node $start
     * @param Node $end
     * @param number $maxOffset
     * @return array|Node[]
     */
    public function findPath(Node $start, Node $end)
    {
        // no path if there is no need for moving
        if ($start->equals($end)) {
            //console("[DEBUG] $start equals $end, route is empty");
            return [];
        }
        if(!$end->canMoveHere($this)){
            //console("[DEBUG] $end is not accessible, path will not be found");
            return false;
        }
        $maxOffsetX = abs($start->x - $end->x);      
        $maxOffsetZ = abs($start->z - $end->z); 
        
        $this->addToOpen($start);
        
        $foundTarget = false;
        
        while (!$foundTarget && count($this->open) > 0) {
            //console("[DEBUG] sorting open nodes by cost. Node count:" . count($this->open));
            uasort(
                $this->open,
                function (Node $a, Node $b) use ($end) {
                    return $a->getFCost($end) - $b->getFCost($end);
                }
                );
            
            /** @var Node $current */
            $current = $this->open[array_keys($this->open)[0]];
            unset($this->open[array_keys($this->open)[0]]);
            
            //console("[DEBUG] current node selected: " . $current);
            
            if ((string)$current == (string)$end) {
                $foundTarget = $current;
                //console("[DEBUG] current node is target node, exiting loop");
                continue;
            }
            
            $adjacent = $current->getAdjacentNodes($this);

            foreach ($adjacent as $node) {
                if (in_array((string)$node, $this->closed)) {
                    //console("[DEBUG] skipping adjacent: $node as it was already processed");
                    continue;
                }
                $node->setParent($current);
                $this->addToOpen($node);
            }
            $this->addToClosed($current);
            
        }
        
        // we failed to find a route
        if (!$foundTarget && count($this->open) == 0) {
            //console("[DEBUG] no open nodes left, and no target found.");
            return false;
        }
        
        //console("[DEBUG] found route!");
        /** @var Node $foundTarget */
        try{
            return $this->createRouteList($foundTarget);
        }finally{ //removing all elements from them
           $this->closed = [];
           $this->open = [];
        }
        
    }
    
    /**
     * @param Node $node
     */
    protected function addToOpen(Node $node)
    {
        if (
            isset($this->open[(string)$node])
            && $this->open[(string)$node]->getGCost() < $node->getGCost()
            ) {
                //console("[DEBUG] skipping add, $node is already known and gcost <= new path");
                return;
            }
            //console("[DEBUG] adding new open node: $node");
            $this->open[(string)$node] = $node;
    }
    
    /**
     * @param Node $node
     */
    protected function addToClosed(Node $node)
    {
        //console("[DEBUG] adding $node to closed");
        $this->closed[] = (string)$node;
    }
    
    /**
     * @param Node $foundTarget
     * @return Node[]
     */
    protected function createRouteList(Node $foundTarget)
    {
        $route = [];
        $route[] = $foundTarget;
        
        while ($foundTarget = $foundTarget->getParentAndCleanSelf()) {
            $route[] = $foundTarget;
        }
        $route = array_reverse($route);
        
        return $route;
    }
}