<?php


class ProductAttributeBase extends ActiveRecord {

  protected $columns = array('id', 'page_id', 'attribute_id', 'stock');
  protected $table_name = 'product_attributes';
  protected $table_vanity_name = 'product_attributes';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
