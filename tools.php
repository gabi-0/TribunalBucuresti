<?php

function numberToRomanRepresentation($number) {
	$map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90,
				'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
	$returnValue = '';
	while ($number > 0) {
		foreach ($map as $roman => $int) {
			if($number >= $int) {
				$number -= $int;
				$returnValue .= $roman;
				break;
			}
		}
	}
	return $returnValue;
}

function ordinalRoman($nr) {
	if($nr <= 1)
		return "I";
	
	return "a ". numberToRomanRepresentation($nr) ."-a";
}


function getBrowser($user_agent)
{
	$browser = "N/A";

	$browsers = [
	'/msie/i' => 'Internet explorer',
	'/firefox/i' => 'Firefox',
	'/safari/i' => 'Safari',
	'/chrome/i' => 'Chrome',
	'/edge/i' => 'Edge',
	'/opera/i' => 'Opera',
	//'/mobile/i' => 'Mobile browser',
	];

	foreach ($browsers as $regex => $value) {
		if (preg_match($regex, $user_agent)) {
			$browser = $value;
		}
	}

	return $browser;
}