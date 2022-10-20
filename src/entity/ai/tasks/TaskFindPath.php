<?php

class TaskFindPath extends TaskBase
{
    public function shouldBeExecuted(EntityAI $ai)
    {
        return !$ai->entity->pathFound && $ai->entity->target instanceof Entity && $ai->entity->moveTime <= 0;
    }

    public function onUpdate(EntityAI $ai)
    {
        console("find path!");
    }
    public function wasExecuted(EntityAI $ai)
    {
        return $ai->entity->pathFound;
    }
    public function onStart(EntityAI $ai)
    {
        //todo?
    }



}

