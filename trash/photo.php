<?php

class Photo extends ActiveRecord\Model {
	
	static $versions = array(
		'quad/'	=> ' -resize 60x60^ -gravity center -extent 60x60 ',
		'thumbs/'=> ' -resize 70x80\> ',
		'small/'=> ' -resize 150x150\> ',
		'medium/'=> ' -resize 300x300\> ',
		'screen/'=> ' -resize 480x600\> '
	);
	public function url_photo($version){
		return Helper::url_photo($this, $version, 'name', 'photos');
	}
	
	public function upload($page_id, $file, $desc='')
	{
		if (!is_uploaded_file($file['tmp_name']))
			throw new Exception('Not file uploaded.');
		$photo = new Photo();
		$photo->page_id = $page_id;
		$photo->description = $desc;
		list($name, $ext)=explode('.',$file['name']);
		$photo->name = uniqid().'.'.$ext;
		$photo->save();
		$dir =  Config::$path_photos . $photo->id.'/';
		foreach( Photo::$versions as $version => $value ){
			@mkdir( $dir.$version, 0777, TRUE );
			//error_log( $dir.$version , 4);
			$str_exec = "convert ".$file['tmp_name'] . $value . $dir.$version.$photo->name;
			//error_log( $str_exec , 4);
			exec( $str_exec );
		}
		move_uploaded_file($file['tmp_name'], $dir.$photo->name);
		//exit;
		
	}
	
	public function del_photo()
	{
		$dir =  Config::$path_photos.$this->id.'/';
		$this->rmdirr($dir);
		$this->destroy();
	}
	
	private function rmdirr($dirname)
	{
	    if (!file_exists($dirname)):
	        return false;
	    endif;
	    if (is_file($dirname) || is_link($dirname)):
	        return unlink($dirname);
	    endif;
	    $dir = dir($dirname);
	    while (false !== $entry = $dir->read()):
	        if ($entry == '.' || $entry == '..'):
	            continue;
	        endif;
	        self::rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
	    endwhile;
	    $dir->close();
	    return rmdir($dirname);
	}

}

?>
