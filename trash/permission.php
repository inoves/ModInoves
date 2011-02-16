<?php
class Permission extends ActiveRecord\Model {

  protected $columns = array('id', 'group_id', 'controller', 'action');
  protected $table_name = 'permissions';
  protected $table_vanity_name = 'permissions';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }

	public function before_save(){}

}
?>
