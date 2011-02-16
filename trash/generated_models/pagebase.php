<?php


class PageBase extends ActiveRecord {
//
  protected $columns = array('id', 'show_home', 'menu_id', 'product', 'user_id', 'active',  'order_home', 'order_menu', 'created_at', 'show_gallery', 'template_name');
  protected $table_name = 'pages';
  protected $table_vanity_name = 'pages';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }

}
?>
