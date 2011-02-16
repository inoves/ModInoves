<?php
class Container extends ActiveRecord\Model {
	
	public function actives()
	{
		return Container::find("all", array("conditions"=>"active=1 AND lang=" . ActiveRecord::quote(self::$lang) . " AND active=1", 'order'=>'ord'));
	}
	
	public function actives_and_visibles()
	{
		return Container::find("all", array("conditions"=>"active=1 AND visible=1 AND lang=" . ActiveRecord::quote(self::$lang) . " AND active=1", 'order'=>'ord'));
	}
	
	public function menus($menu=null)
	{
		return Menu::find("all", array("conditions"=>"lang=" . ActiveRecord::quote(self::$lang) . " AND container_id=".$this->id . " AND parent_id=0", "order"=>"ord"));
	}
	
	public function all_menus()
	{
		return Menu::find("all", array("conditions"=>"lang=" . ActiveRecord::quote(self::$lang) . " AND container_id=".$this->id, "order"=>"ord"));
	}
	
	public function menus_active()
	{
		return Menu::find("all", array("conditions"=>"parent_id=0 AND lang=" . ActiveRecord::quote(self::$lang) . " AND active=1 AND container_id=".$this->id, "order"=>"ord"));
	}
	
	public function last_id()
	{
		return (int)Container::find('first', array('select'=>'MAX(id) as id'))->id;
	}

}

