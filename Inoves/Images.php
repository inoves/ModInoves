<?php
/**
* 
*/
class Inoves_Images
{
	
	static private $hosts_images = array(
		'http://img1.frameinoves',
		'http://img2.frameinoves',
		'http://img3.frameinoves'
		);
	
	
	function url($image)
	{
		return self::$hosts_images[rand(0, count(self::$hosts_images))].$image;
	}
}
