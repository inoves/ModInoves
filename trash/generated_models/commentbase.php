<?php
//

class CommentBase extends ActiveRecord {

  protected $columns = array('id', 'user_id', 'subject', 'content', 'active', 'page_id');
  protected $table_name = 'comments';
  protected $table_vanity_name = 'comments';
  protected $primary_key = 'id';

  static function find($id, $options=null) {
    return parent::find(__CLASS__, $id, $options);
  }
}
?>
