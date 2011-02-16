<?php
/**
* 
*/
class Item
{
	public $uuid;
	public $page_id;
	public $quant;
	public $price;
	public $attrib;
	public $attrib_name;
	
	function __construct($page_id=null, $quant=1)
	{
		$prod = PagesProduct::find('first', array('conditions' => 'page_id='.ActiveRecord::quote($page_id)));
		if ($prod):
			$this->uuid = uniqid(mt_rand(), true);
			$this->page_id = $page_id;
			$this->quant = $quant;
			$this->price = $prod->price;
		else:
			return false;
		endif;
	}
	function price($decimals = 2, $dec_point = ",", $sep=" "){
		return number_format($this->price, $decimals, $dec_point, $sep);
	}
	function description(){return PagesDescription::find('first', array('conditions'=>'lang='.ActiveRecord::quote(ActiveRecord::$lang).' AND page_id='.$this->page_id))->title;}
	function subtotal($decimals = 2, $dec_point = ",", $sep=" "){return number_format(($this->quant * $this->price), $decimals, $dec_point, $sep);}
	function set_quant($quant=1){$this->quant = $quant;}
}

