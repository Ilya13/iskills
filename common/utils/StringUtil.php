<?php

namespace common\utils;

class StringUtil {
		
	public static function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}

	public static function shipsToString($ships) {
		$years = intval($ships/365);
		$ships = $ships%365;
		$months = intval($ships/30);
		$ships = $ships%30;
		$weeks = intval($ships/7);
		$days = $ships%7;
		
		$result = static::yearsToString($years);
		$mothsStr = static::monthsToString($months);
		if ($mothsStr !== ""){
			if ($result !== ""){
				$result .= " ";
			}
			$result .= $mothsStr;
		}
		$weeksStr = static::weeksToString($weeks);
		if ($weeksStr !== ""){
			if ($result !== ""){
				$result .= " ";
			}
			$result .= $weeksStr;
		}
		$daysStr = static::daysToString($days);
		if ($daysStr !== ""){
			if ($result !== ""){
				$result .= " ";
			}
			$result .= $daysStr;
		}
		
		return $result;
	}
	
	public static function yearsToString($years){
		if ($years === 0){
			return "";
		}
		return $years." ".static::declension($years, ["год", "года", "лет"]);
	}
	
	public static function monthsToString($months){
		if ($months === 0){
			return "";
		}
		return $months." ".static::declension($months, ["месяц", "месяца", "месяцев"]);
	}
	
	public static function weeksToString($weeks){
		if ($weeks === 0){
			return "";
		}
		return $weeks." ".static::declension($weeks, ["неделю", "недели", "недель"]);
	}
	
	public static function daysToString($days){
		if ($days === 0){
			return "";
		}
		return $days." ".static::declension($days, ["день", "дня", "дней"]);
	}
	
	function declension($int, $expressions) {
		if (count($expressions) < 3) 
			$expressions[2] = $expressions[1];
		settype($int, "integer");
		$count = $int % 100;
		if ($count >= 5 && $count <= 20) {
			$result = $expressions['2'];
		} else {
			$count = $count % 10;
			if ($count == 1) {
				$result = $expressions['0'];
			} elseif ($count >= 2 && $count <= 4) {
				$result = $expressions['1'];
			} else {
				$result = $expressions['2'];
			}
		}
		return $result;
	}
	
	function GUID() {
		if (function_exists('com_create_guid') === true) {
			return trim(com_create_guid(), '{}');
		}
	
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
}