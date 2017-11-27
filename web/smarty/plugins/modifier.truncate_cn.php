<?php
/**
* Smarty plugin
* @package Smarty
* @subpackage plugins
*/

/**
* ×Ö·û½ØÈ¡ Smarty truncate modifier plugin
* Type:     modifier<br>
* Name:     truncate<br>
* Purpose: Truncate a string to a certain length if necessary,
*           optionally splitting in the middle of a word, and
*           appending the $etc string or inserting $etc into the middle.
* @link   http://smarty.php.net/manual/en/language.modifier.truncate.php
*          truncate (Smarty online manual)
* @author   tianhm<tech at uenu dot com>
* @param string $string
* @param int $length
* @param string $code
* @param string $etc
* @return   string
*/

function smarty_modifier_truncate_cn($string,$length=0,$ellipsis='¡­',$start=0){
	$string=strip_tags($string);
	$string=preg_replace('/\n/is','',$string);
	//$string=preg_replace('/ |¡¡/is','',$string);//Çå³ý×Ö·û´®ÖÐµÄ¿Õ¸ñ
	$string=preg_replace('/&nbsp;/is','',$string);
	preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/",$string,$string);
	if(is_array($string)&&!empty($string[0])){
		$string=implode('',$string[0]);
		if(strlen($string)<$start+1){
			return '';
		}
		preg_match_all("/./su",$string,$ar);
		$string2='';
		$tstr='';
		//www.phpernote.com
		for($i=0;isset($ar[0][$i]);$i++){
			if(strlen($tstr)<$start){
				$tstr.=$ar[0][$i];
			}else{
				if(strlen($string2)<$length+strlen($ar[0][$i])){
					$string2.=$ar[0][$i];
				}else{
					break;
				}
			}
		}
		return $string==$string2?$string2:$string2/*.$ellipsis*/;
	}else{
		$string='';
	}
	return $string;
}

?>
