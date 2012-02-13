<?php
//

class BanneBase extends ActiveRecord {

  protected $columns = array('id', 'name', 'description', 'link', 'clicks', 'views', 'lang');
  protected $table_name = 'banners';
  protected $table_vanity_name = 'banners';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
