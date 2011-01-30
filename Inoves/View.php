<?php
/**
* 
*/
class Inoves_View extends Inoves_View_HTML
{

	
	static public function check($value='')
	{
		return tidy_access_count($value);
	}
	
	
	
	
}