<?php

namespace Core;

class ArrayHelper
{
	public static function get (array $mass, string $key, $default) {
		
		return array_key_exists($key, $mass) ? $mass[$key] : $default;
	}
	
	public static function extraction (array $mass, array $schem) {
		$ready = [];
		foreach ($schem as $k=>$v) {
			$ready[$k] = self::get($mass, $v, null);			
		}
		return $ready;
	}
}