<?php

class TaskRandomWalk extends TaskBase
{
    public function shouldBeExecuted(EntityAI $ai)
    {
        return !$ai->entity->pathFound && $ai->entity->moveTime <= 0 && $ai->entity->lookTime <= 0 && !($ai->entity->target instanceof Entity) && mt_rand(0,3) == 1;
    }

    public function onUpdate(EntityAI $ai)
    {
        console("random walk");
    }
    public function wasExecuted(EntityAI $ai)
    {
        return $ai->entity->moveTime > 0;
    }
    public function onStart(EntityAI $ai)
    {
        $ai->entity->moveTime = 100;
    }



}

