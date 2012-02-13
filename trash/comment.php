<?php
class Comment extends ActiveRecord\Model {

	protected $belongs_to = array('page');
	
	
}