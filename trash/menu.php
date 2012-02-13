<?php

class Menu extends ActiveRecord\Model {

	function find_lang_by_id($id){
		return Menu::find('first', array('conditions'=>"active=1 AND lang='" . ActiveRecord::$lang . "' AND id=".$id));
	}
	function breadcrumb($menu, $html)
	{
	    $html =   ' &gt;  <a href="/menu/' . $menu->id . '"><span>'.$menu->name.'</span></a>' . $html;
	    if($new_menu = Menu::find('first', array('conditions'=>"active=1 AND lang=".ActiveRecord::quote($_COOKIE['language'])." AND parent_id=".$menu->id))):
	      $html = $this->breadcrumb($new_menu , $html);
	    endif;
	    return  $html;
	}
	
	public function path_menu()
	{
		return "menu/".$this->id;
	}
	
	public function last_id()
	{
		return Menu::find('first', array('select'=>'MAX(id) as id'))->id;
	}
	
	public function menus(){
		return Menu::find('all', array('conditions'=>'lang=' . ActiveRecord::quote(self::$lang) . ' AND parent_id='.ActiveRecord::quote($this->id)));
	}
	
	public function menus_actives(){
		return Menu::find('all', array('conditions'=>'active=1 AND lang=' . ActiveRecord::quote(self::$lang) . ' AND parent_id='.ActiveRecord::quote($this->id)));
	}
	
	public function parent_this(){
		return Menu::find('first', array('conditions'=>'lang=' . ActiveRecord::quote(self::$lang) . ' AND id='.ActiveRecord::quote($this->parent_id)));
	}

}

?>
