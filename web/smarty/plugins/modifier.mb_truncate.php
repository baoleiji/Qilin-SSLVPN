<?php

function smarty_modifier_mb_truncate($string, $length = 80, $etc = 'бн', $charset='UTF-8',$break_words = false, $middle = false)
{
	if ($length == 0)
	return '';if (strlen($string) > $length) {
	$length -= strlen($etc);
	if (!$break_words && !$middle) {
	$string = preg_replace('/\s+?(\S+)?$/', '', CnSubstr($string, 0, $length+1));
	}
	if(!$middle) {
	return CnSubstr($string, 0, $length).$etc;
	} else {
	return CnSubstr($string, 0, $length/2) . $etc . CnSubstr($string, -$length/2);
	}
	} else {
	return $string;
	}
	}function CnSubstr($str,$start,$len)
	{
	for($i=0;$i<$start+$len;$i++)
	{
	$tmpstr=(ord($str[$i])>=161 && ord($str[$i])<=254&& ord($str[$i+1])>=161 && ord($str[$i+1])<=254)?$str[$i].$str[++$i]:$tmpstr=$str[$i];
	if ($i>=$start&&$i<($start+$len))$tmp .=$tmpstr;
	}
	return $tmp;
}



?>
