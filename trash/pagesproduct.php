<?php

class PagesProduct extends ActiveRecord\Model {
	protected $belongs_to  = array('manufacture', 'page');
}