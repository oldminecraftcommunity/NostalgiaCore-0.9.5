<?php

class EntityAI
{
	/**
	 * @var MobController
	 */
	public $mobController;
	/**
	 * @var Living
	 */
	public $entity;
	
	/**
	 * @var TaskBase[]
	 */
	protected $tasks;
	
	public $lastTask;
	
	public function __construct($entity){
		$this->entity = $entity;
		$this->tasks = [];
		$this->mobController = new MobController($entity);
	}
	
	/**
	 * Add a task for entity
	 * @param TaskBase $task
	 */
	public function addTask(TaskBase $task){
		console("[DEBUG] Adding new task...",true, true, 2);
		$this->tasks[$task->__toString()] = $task;
	}
	public function removeTask($name){
		if(isset($this->tasks[$name])){
			unset($this->tasks[$name]);
			return true;
		}
		return false;
	}
	
	/**
	 * 
	 * @param mixed $id classname
	 * @return TaskBase | false
	 */
	public function getTask($id){
		return isset($this->tasks[$id]) ? $this->tasks[$id] : false;
	}
	
	public function isStarted($id){
		$task = @$this->getTask($id);
		return $task instanceof TaskBase && $task->isStarted;
	}

	public function updateTasks(){
		if(!($this->entity instanceof Entity)) return;
		foreach($this->tasks as $t){
			if(!$t->isStarted && $t->canBeExecuted($this)){
				$t->isStarted = true;
				$t->onStart($this);
			}
			if($t->isStarted){
				$t->onUpdate($this);
				if($t->selfCounter <= 0){
					$t->isStarted = false;
					$t->onEnd($this);
				}
			}
		}
	}
	
	public function __destruct(){
		unset($this->entity);
	}
	
}

