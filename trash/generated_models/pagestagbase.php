<?php

class PagesTagBase extends ActiveRecord {

  protected $columns = array('id', 'tag_id', 'page_id');
  protected $table_name = 'pages_tags';
  protected $table_vanity_name = 'pages_tags';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
