<?php
class Banner extends ActiveRecord\Model {
	
	static $versions = array(
		'quad/'	=> ' -resize 60x60^ -gravity center -extent 60x60 ',
		'thumbs/'=> ' -resize 60x60\> ',
		
		//banners sizes
		'h_728_90/'=> ' -resize 728x90\> ',
		'h_468_60/'=> ' -resize 428x60\> ',
		//'h_234_60/'=> ' -resize 234x60\> ',
		'v_120_600/'=> ' -resize 120x600\> ',
		//'v_160_600/'=> ' -resize 160x600\> ',
		'v_120_240/'=> ' -resize 120x240\> ',
		//'sq_336_280/'=> ' -resize 336x280\> ',
		//'sq_300_250/'=> ' -resize 300x250\> ',
		'sq_250_250/'=> ' -resize 250x250\> ',
		'sq_200_200/'=> ' -resize 200x200\> ',
		//'sq_180_150/'=> ' -resize 180x150\> ',
		
		'screen/'=> ' -resize 480x600\> '
	);
	
	public function upload($page_id, $file, $desc='')
	{
		if (!is_uploaded_file($file['tmp_name'])):
			throw new Exception('Not file uploaded.');
		endif;
		$photo = new Photo();
		$photo->page_id = $page_id;
		$photo->description = $desc;
		$photo->name = $file['name'];
		$photo->save();
		$dir =  Config::$path_webroot . 'images/photos/'.$photo->id.'/';
		foreach( Photo::$versions as $version => $value ){
			@mkdir( $dir.$version, 0777, TRUE );
			$str_exec = "convert ".$file['tmp_name'] . $value . $dir.$version.$file['name'];
			@exec($str_exec);
		}
		move_uploaded_file($file['tmp_name'], $dir.$file['name']);
		
	}
	
	public function del_photo()
	{
		$dir =  Config::$path_webroot . 'images/photos/'.$this->id.'/';
		$this->rmdirr($dir);
		$this->destroy();
	}
	
	protected function rmdirr($dirname)
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
	        Photo::rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
	    endwhile;
	    $dir->close();
	    return rmdir($dirname);
	}

}
