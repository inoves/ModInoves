<?php


class PagesDescriptionBase extends ActiveRecord {

  protected $columns = array('page_id', 'title', 'intro', 'content', 'created_at', 'lang', 'serial', 'personal_fields');
  protected $table_name = 'pages_descriptions';
  protected $table_vanity_name = 'pages_descriptions';
  protected $primary_key = 'serial';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
