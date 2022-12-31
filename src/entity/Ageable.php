<?php

interface Ageable{
	public function isBaby();
	/**
	 * Get Entity Age. It can be negative.
	 */
	public function getAge();
	/**
	 * Set Entity age.
	 * @param int $i
	 */
	public function setAge($i);
}