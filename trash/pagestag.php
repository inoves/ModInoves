<?php
class PagesTag extends ActiveRecord\Model {
	protected $belongs_to = array('page', 'tag');
}

?>
