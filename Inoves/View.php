<?php
/**
* 
*/
class Inoves_View extends Inoves_View_Placeholder 
//Inoves_View_HTML
{
	static public function check($value='', $config=array(), $encoding='utf8')
	{
		return tidy_access_count(tidy_parse_string($value, $config, $encoding));
	}
	
}