<?php
class ManufactureBase extends ActiveRecord {

  protected $columns = array('id', 'name', 'site', 'image', 'description');
  protected $table_name = 'manufactures';
  protected $table_vanity_name = 'manufactures';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
