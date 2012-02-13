<?php
class Cart
{
	public $items = array();
	
	function __construct(){
		//echo "string";
		$this->items = array();
	}
	
	public function add_item($page_id='', $attrib=null, $quant=1)
	{
		$new=true;
		foreach ($this->items as $uuid => $prod) {
			if ($prod->page_id == $page_id && $prod->attrib == $attrib):
				$prod->quant++;
				$new=false;
			endif;
		}
		if ($new):
			$item = new Item($page_id, $quant);
			$item->attrib = $attrib;
			if ($attrib):
				$item->attrib_name = Attribute::find($attrib)->name;
			endif;
			$this->items[$item->uuid] = $item;
		endif;
	}
	
	public function remove_item($uuid)
	{
		unset($this->items[$uuid]);
	}
	
	public function update_quant($uuid, $quant)
	{
		$this->items[$uuid]->quant = (int)$quant;
	}
	
	public function set_attrib($uuid,$attrib)
	{
		$this->items[$uuid]->attrib=$attrib;
	}
	
	public function total_items(){
		return array_reduce($this->items, create_function('$v,$i', '$v+=$i->quant;return $v;'));
	}
	public function total($decimals = 2, $dec_point = ",", $sep=" ")
	{
		return number_format(array_reduce($this->items, create_function('$v,$i', '$v+=$i->quant*$i->price;return $v;')), $decimals, $dec_point, $sep);
	}
}