<?php

abstract class TaskBase
{
    /**
     * @param EntityAI $ai
     * @return bool
     */
    abstract function shouldBeExecuted(EntityAI $ai);
    
    /**
     * @param EntityAI $ai
     * @return bool
     */
    abstract function wasExecuted(EntityAI $ai);
    
    /**
     * @param EntityAI $ai
     */
    abstract function onStart(EntityAI $ai);
    
    /**
     * @param EntityAI $ai
     */
    abstract function onUpdate(EntityAI $ai);
}

