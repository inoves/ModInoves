<?php
//

class ContainerBase extends ActiveRecord {

  protected $columns = array('id', 'name', 'lang', 'serial', 'active', 'ord', 'visible');
  protected $table_name = 'containers';
  protected $table_vanity_name = 'containers';
  protected $primary_key = 'serial';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
