<?php
//

class PhotoBase extends ActiveRecord {

  protected $columns = array('id', 'name', 'description', 'lang', 'page_id');
  protected $table_name = 'photos';
  protected $table_vanity_name = 'photos';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
