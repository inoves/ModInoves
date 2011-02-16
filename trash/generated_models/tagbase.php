<?php


class TagBase extends ActiveRecord {

  protected $columns = array('id', 'name');
  protected $table_name = 'tags';
  protected $table_vanity_name = 'tags';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
