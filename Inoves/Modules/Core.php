<?php
/**
* 
*/
class Inoves_Modules_Core
{
	public $order = -10;
	
	function __construct()
	{
		if($this->order>0 && $this->order<-10){
			throw new Inoves_Exception_Modules("Order of core modules worng!");
			
		}
	}
}
