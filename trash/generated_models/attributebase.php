<?php
//

class AttributeBase extends ActiveRecord {

  protected $columns = array('id', 'name', 'gr');
  protected $table_name = 'attributes';
  protected $table_vanity_name = 'attributes';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
