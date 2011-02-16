<?php
//

class CustomerBase extends ActiveRecord {

  protected $columns = array('id', 'username', 'password', 'created_at');
  protected $table_name = 'customers';
  protected $table_vanity_name = 'customers';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
