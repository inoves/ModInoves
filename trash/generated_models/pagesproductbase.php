<?php


class PagesProductBase extends ActiveRecord {

  protected $columns = array('id', 'page_id', 'price', 'manufacture_id', 'reference', 'show_old_price', 'created_at', 'promo_flag', 'new_flag', 'old_price', 'order_manufacture');
  protected $table_name = 'pages_products';
  protected $table_vanity_name = 'pages_products';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
