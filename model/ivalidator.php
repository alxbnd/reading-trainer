<?php

namespace Model;

interface iValidator
{
	/**
	* @param array $rules
	*
	* set rules
	*/
	public function __construct (array $rules);
	
	/*
	* @array $fields
	*
	* @return array with errors or false
	*/
	public function run (array $fields); 
	
	/*
	* @return array with clean data
	*/
	public function get_clean ();
	
	/*
	* @array $input
	*
	* @array $true
	*
	* @return array with response
	*/
	public function check (array $input, array $true);
}