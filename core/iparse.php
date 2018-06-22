<?php

namespace Core;

interface iParse
{
	/**
	* @param array $words
	*
	* @param array $scheme
	*
	* @param string $agent
	*/
	public function __construct ($words, $scheme, $agent);
	 
	/**
	* @param string $type
	*
	* @return array $obj
	*/
	public function run ($type);
	
	/**
	* @return array $mean
	*/
	public function parse_mean ($word);
}