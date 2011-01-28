<?php
/**
* 
*/
class Inoves_Modules
{
	
	public $order = 0;
	
	function __construct()
	{
		if($this->order<0){
			throw new Inoves_Exception_Modules("Order of modules is worng!");
			
		}
	}
}
