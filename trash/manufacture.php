<?php
@ini_set ('file_uploads', true);
@ini_set ('upload_max_filesize', "4M");
@ini_set ('max_execution_time', 60);

class Manufacture extends ActiveRecord\Model {
	
	protected $has_many = array('pages_product');
	
	private $folder_images = "manufactures/";
	private $versions = array(
							'quad/'	=> ' -resize 60x60^ -gravity center -extent 60x60 ',
							'thumbs/'=> ' -resize 60x60\> ',
							'medium/'=> ' -resize 300x300\> ',
							'screen/'=> ' -resize 480x600\> '
							);
							
	public function url_image($version){
		return Helper::url_photo($this, $version, 'image', 'manufactures');
	}
	public function path_folder_images()
	{
		return Config::$path_webroot . $this->folder_images;
	}
	public function path_image($version = '')
	{
		return $this->path_folder_images() .$this->id . DIRECTORY_SEPARATOR . $version;
	}
	public function upload_for_image($file)
	{
		$this->del_photo();
		list($name, $ext)=explode('.',$file['name']);
		$this->image = uniqid().'.'.$ext;
		if (is_uploaded_file($file['tmp_name'])):
			foreach ($this->versions as $version => $value) {
				//create dir
				mkdir( $this->path_image("$version") , 0777, true );
				$exec = "convert " . $file['tmp_name'] . $value . $this->path_image($version) .  $this->image ;
				error_log( $exec , 4);
				exec($exec);
			}
			move_uploaded_file($file['tmp_name'], $this->path_image() . $this->image);
		endif;
	}
	
	
	public function del_photo()
	{
		$dir =  $this->path_folder_images() .$this->id;
		$this->rmdirr($dir);
	}
	
	public function delete()
	{
		$this->del_photo();
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