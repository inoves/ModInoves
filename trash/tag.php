<?php


class Tag extends ActiveRecord\Model {

	#
	protected $has_many = array(	'pages_tags',
									array('pages' => array( 'through' => 'pages_tags' ))
								);


	public function find_by_pages($id='')
	{
		$sql = "SELECT * FROM pages_tags inner join tags on pages_tags.tag_id=tags.id WHERE page_id=".$id;
		echo $sql;
		return ActiveRecord::query_obj($sql);
	}
}

?>
