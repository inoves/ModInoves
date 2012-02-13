<?php
class Page extends ActiveRecord\Model {
	
	//public $tags;
	public $product_attributes;
	public $pages_descriptions;
	public $pages_products;
	public $_photos;
	public $_manufacture;
	public $menus;
	
	protected $has_many = array( 'pages_tags',
	                      array('tags' => array('through' => 'pages_tags')),
						array('comments' => array('dependent' => 'destroy')) );
	protected $has_one	= array('pages_product');
	
	public function photos()
	{
		if (!$this->_photos):
			$this->_photos=Photo::find('all', array('conditions' => 'page_id='.$this->id));
		endif;
		return $this->_photos;
	}
	
	public function photo($index=0)
	{
		if (!$this->_photos):
			$this->photos();
		endif;
		return $this->_photos[$index];
	}
	
	function menus(){
		if (!$this->menus):
			$menu = Menu::find_lang_by_id((int)$this->menu_id);
			$mn_id = $menu->parent_id;
			$this->menus[] = $menu; 
			while($mn_id >= 1 ){
				$menu = Menu::find_lang_by_id((int)$menu->parent_id);
				$mn_id = $menu->parent_id;
				$this->menus[] = $menu;
			}
			//$this->menus = $menus;
		endif;
		return $this->menus;
	}
	
	//Return translate of field
	public function descriptions( $field='', $lang=null)
	{
		
		if ($field):
			if(!$lang)
				$lang = self::$lang;
			if (!isset($this->pages_descriptions[$lang])):
				$this->pages_descriptions[$lang] = PagesDescription::find('first', array('conditions'=>'page_id='.$this->id.' AND lang='.ActiveRecord::quote($lang)));
				if ( !isset($this->pages_descriptions[$lang]) ):
					$this->pages_descriptions[$lang] = new PagesDescription();
					$this->pages_descriptions[$lang]->page_id = $this->id;
				endif;
			endif;
			return $this->pages_descriptions[$lang]->$field;
		else:
			foreach (Config::$languages as $lang) {
				if (!isset($this->pages_descriptions[$lang])):
					$this->pages_descriptions[$lang] =  PagesDescription::find('first', array('conditions'=>'page_id='.$this->id.' AND lang='.ActiveRecord::quote($lang)));
					if (!isset($this->pages_descriptions[$lang])):
						$this->pages_descriptions[$lang] = new PagesDescription();
						$this->pages_descriptions[$lang]->page_id = $this->id;
					endif;
					$this->pages_descriptions[$lang]->lang = $lang;
				endif;
			}
			return $this->pages_descriptions;
		endif;
	}
	
	public function price($decimals = 2, $dec_point = ",", $sep=" ")
	{
		return number_format($this->product()->price,$decimals, $dec_point, $sep);
	}
	public function old_price($decimals = 2, $dec_point = ",", $sep=" ")
	{
		return number_format($this->product()->old_price,$decimals, $dec_point, $sep);
	}
	
	//Return field of product page
	public function product($field=false)
	{
		if (!$this->pages_products):
			$this->pages_products = $this->pages_product;
			//$this->pages_products = PagesProduct::find('first', array('conditions'=>'page_id='.$this->id));
			if (!$this->pages_products):
				$this->pages_products = new PagesProduct();
				$this->pages_products->page_id = $this->id;
			endif;
		endif;
		return ($field) ? $this->pages_products->$field : $this->pages_products;
	}
	
	function manufacture($field=false){
		if (!$this->_manufacture):
			$this->_manufacture = Manufacture::find((int)$this->product()->manufacture_id);
		endif;
		return ($field)  ? $this->_manufacture->$field : $this->manufacture;
	}
	
	
	public function product_attributes()
	{
		if (!isset($this->product_attributes))
			$this->product_attributes = ProductAttribute::query_obj('SELECT attributes.* FROM product_attributes, attributes WHERE product_attributes.attribute_id=attributes.id AND product_attributes.page_id='.$this->id);
		return $this->product_attributes;
	}
	
	public function tags()
	{
		return $this->tags;
	}
	
	public function find_tags()
	{
		$tags = $this->tags();
		$r_tags = array();
		foreach ($tags as $tag) {
			$r_tags[] = $tag->name;
		}
		return join(", ", $r_tags);
	}
	
	public function author_name()
	{
		try{
			return User::find($this->user_id)->name;
		}catch(Exception $e){
			return '';
		}
	}
	public function remove_all()
	{
		try{
			@ActiveRecord::query('BEGIN');
				ActiveRecord::query('DELETE FROM pages_tags WHERE page_id='.$this->id);
				ActiveRecord::query('DELETE FROM pages_descriptions WHERE page_id='.$this->id);
				ActiveRecord::query('DELETE FROM pages_products WHERE page_id='.$this->id);
				ActiveRecord::query('DELETE FROM product_attributes WHERE page_id='.$this->id);
				ActiveRecord::query('DELETE FROM comments WHERE page_id='.$this->id);
				$photos = $this->photos();
				foreach ($photos as $photo) {
					$photo->del_photo();
				}
			@ActiveRecord::query('COMMIT');
		}catch(Exception $e){
			@ActiveRecord::query('ROLLBACK');
		}
	}
	
	public function with_tags($tags_ar='')
	{
		PagesTag::query('DELETE FROM pages_tags WHERE page_id='.$this->id);
		$tags = (is_array($tags_ar)) ? $tags_ar : explode(',', $tags_ar);
		foreach ($tags as $tag_name):
			$tag_name = preg_replace('/^\s+/', '', $tag_name);
			$tag_name = preg_replace('/\s+$/', '', $tag_name);
			if ($tag_name!=''):
				$tag = Tag::find('first', array('conditions'=>"name=".ActiveRecord::quote($tag_name)));
				if (!isset($tag)):
					$tag = new Tag(array('name'=>$tag_name));
					$tag->save();
				endif;
				$page_tag = new PagesTag(array('page_id'=>$this->id, 'tag_id'=>$tag->id));
				$page_tag->save();
			endif;
		endforeach;
	}
	
	
	function similar(){
		//TODO: Increase this
		return Page::find( 'all', array('conditions'=>'id<> ' . $this->id . ' AND product=1 AND menu_id='.$this->menu_id, 'limit'=>4 ));
	}
	
}
