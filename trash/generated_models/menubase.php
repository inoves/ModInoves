<?php
//

class MenuBase extends ActiveRecord {

  protected $columns = array('id', 'serial', 'lang', 'name', 'active', 'description', 'typeof', 'created_at', 'parent_id', 'container_id', 'ord', 'value_typeof');
  protected $table_name = 'menus';
  protected $table_vanity_name = 'menus';
  protected $primary_key = 'serial';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
