<?php
//

class UserBase extends ActiveRecord {

  protected $columns = array('id', 'name', 'created_at', 'username', 'password', 'group_id', 'admin');
  protected $table_name = 'users';
  protected $table_vanity_name = 'users';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
