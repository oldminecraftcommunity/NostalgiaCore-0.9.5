<?php
/*
Used in PHAR plugins to load all custom classes
*/
interface IClassLoader{
	public function loadAll($pharPath);
}