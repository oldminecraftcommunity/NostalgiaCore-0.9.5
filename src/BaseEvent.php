<?php

abstract class BaseEvent{

	const ALLOW = 0;
	const DENY = 1;
	const NORMAL = 2;
	const FORCE = 0x80000000;

	/**
	 * Any callable event must declare the static variables
	 *
	 * public static $handlers;
	 * public static $handlerPriority;
	 *
	 * Not doing so will deny the proper event initialization
	 */

	protected $eventName = null;
	private $status = BaseEvent::NORMAL;
	private $prioritySlot;

	public static function getHandlerList(){
		return static::$handlers;
	}

	public static function getPriorityList(){
		return static::$handlerPriority;
	}

	public static function unregisterAll(){
		static::$handlers = [];
		static::$handlerPriority = [];
	}

	public static function register(callable $handler, $priority = EventPriority::NORMAL){
		if($priority < EventPriority::MONITOR or $priority > EventPriority::LOWEST){
			return false;
		}
		$identifier = Utils::getCallableIdentifier($handler);
		if(isset(static::$handlers[$identifier])){ //Already registered
			return false;
		}else{
			static::$handlers[$identifier] = $handler;
			if(!isset(static::$handlerPriority[(int) $priority])){
				static::$handlerPriority[(int) $priority] = [];
				krsort(static::$handlerPriority);
			}
			static::$handlerPriority[(int) $priority][$identifier] = $handler;
			return true;
		}
	}

	public static function unregister(callable $handler, $priority = EventPriority::NORMAL){
		$identifier = Utils::getCallableIdentifier($handler);
		if(isset(static::$handlers[$identifier])){
			if(isset(static::$handlerPriority[(int) $priority][$identifier])){
				unset(static::$handlerPriority[(int) $priority][$identifier]);
			}else{
				for($priority = EventPriority::MONITOR; $priority <= EventPriority::LOWEST; ++$priority){
					unset(static::$handlerPriority[$priority][$identifier]);
					if(count(static::$handlerPriority[$priority]) === 0){
						unset(static::$handlerPriority[$priority]);
					}
				}
			}
			unset(static::$handlers[$identifier]);
			return true;
		}else{
			return false;
		}
	}

	final public function getEventName(){
		return $this->eventName !== null ? get_class($this) : $this->eventName;
	}

	final public function getPrioritySlot(){
		return (int) $this->prioritySlot;
	}

	final public function setPrioritySlot($slot){
		$this->prioritySlot = (int) $slot;
	}

	public function isAllowed(){
		return ($this->status & 0x7FFFFFFF) === BaseEvent::ALLOW;
	}

	public function setAllowed($forceAllow = false){
		$this->status = BaseEvent::ALLOW | ($forceAllow === true ? BaseEvent::FORCE : 0);
	}

	public function isCancelled(){
		return ($this->status & 0x7FFFFFFF) === BaseEvent::DENY;
	}

	public function setCancelled($forceCancel = false){
		if($this instanceof CancellableEvent){
			$this->status = BaseEvent::DENY | ($forceCancel === true ? BaseEvent::FORCE : 0);
		}
		return false;
	}

	public function isNormal(){
		return $this->status === BaseEvent::NORMAL;
	}

	public function setNormal(){
		$this->status = BaseEvent::NORMAL;
	}

	public function isForced(){
		return ($this->status & BaseEvent::FORCE) > 0;
	}
}
