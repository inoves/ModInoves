<?php
/*
 * Modelo de acesso aos dados Twitter
 */
class MyTwitter{
	
	private $o_twitter 	= null;
	private $expireted_at = 0.005;//days
	
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	
	function __construct(){
		var_dump(Config::$twitter_u, Config::$twitter_p );
		$this->o_twitter = new Twitter(Config::$twitter_u, Config::$twitter_p );
		//var_dump($this->o_twitter->test());
		$this->cache_expireted_at = Config::$twitter_cache_expireted_at;
		var_dump($this->o_twitter->verifyCredentials());
	}
	
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	
	/**
	 * Envia Twitter e guarda em cache os ultimos 20 twitters
     * @return SimpleXMLElement Object
     **/
	function create($mensage){
		$this->o_twitter->updateStatus(substr($mensage,0, 139));
		return $this->cache_my_twitter();
	}
	
	
	function remove($id){
		if($this->o_twitter->deleteStatus($id))
			return $this->cache_my_twitter();
	}
	
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	

	

	
	/**
	 * Retorna os twitters guardados em cache
     * @return SimpleXMLElement Object
     **/	
	function my_twitters(){
		return $this->open_cache_my_twitter();
	}
	/**
	 * Abre o arquivo de cache, se não houver guarda ficheiro com novo cache
     * @return SimpleXMLElement Object
     **/
	private function open_cache_my_twitter(){
		$file_name = Config::$path_webroot . '../cache/twitter/updates.xml';
		if($this->validate_cache($file_name, $this->cache_expireted_at) ){
			return simplexml_load_file($file_name);
		}else{
			return $this->cache_my_twitter();
		}
	}
	/**
	 * retorna os twitters em cache
     * @return SimpleXMLElement Object
     **/
	private function cache_my_twitter(){
		try{
			var_dump($this->o_twitter->getUserTimeline());exit;
			$file_name = Config::$path_webroot . '../cache/twitter/updates.xml';
			$this->rm_file($file_name);
			$xml = $this->o_twitter->getUserTimeline();
			file_put_contents( $file_name, $xml->asXML() );
			return $xml;
		}catch( Exception $e ){
			var_dump($e);exit;
			BaseController::redirect_to('/admin/pages');
		}
	}
	
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	
	/**
	 * Guarda em cache os replies
     * @return SimpleXMLElement Object
     **/
	private function cache_my_replies(){
		$file_name = Config::$path_webroot . '../cache/twitter/replies.xml';
		$this->rm_file($file_name);
		$xml = $this->o_twitter->getMentionsReplies();
		file_put_contents( $file_name, $xml->asXML() );
		return $xml;
	}
	
	/**
	 * Abre ficheiro de cache dos replies
     * @return SimpleXMLElement Object
     **/
	private function open_cache_my_replies(){
		$file_name = Config::$path_webroot . '../cache/twitter/replies.xml';
		if($this->validate_cache($file_name, $this->cache_expireted_at))
			return simplexml_load_file($file_name);
		else
			return $this->cache_my_replies();
	}
	/**
	 * Return os replies enviados do twitter
     * @return SimpleXMLElement Object
     **/
	function my_replies(){
		return $this->open_cache_my_replies();
	}
	
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	
	/**
	 * Guarda em cache 'friends'
     * @return SimpleXMLElement Object
     **/
	private function cache_my_friends(){
		$file_name = Config::$path_webroot . '../cache/twitter/friends.xml';
		$this->rm_file($file_name);
		$xml = $this->o_twitter->getFollowers();
		file_put_contents( $file_name, $xml->asXML() );
		return $xml;
	}
	
	/**
	 * Abre ficheiro de cache 'friends'
     * @return SimpleXMLElement Object
     **/
	private function open_cache_my_friends(){
		$file_name = Config::$path_webroot . '../cache/twitter/friends.xml';
		if($this->validate_cache($file_name, $this->cache_expireted_at))
			return simplexml_load_file($file_name);
		else
			return $this->cache_my_friends();
	}
	
	/**
	 * Return os friends
     * @return SimpleXMLElement Object
     **/
	function my_friends(){
		return $this->open_cache_my_friends();
	}
	
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	
	private function validate_cache($file, $days=1){
		if(!file_exists($file))
			return false;
		//pega a data do arquivo
		$time_file =  filectime($file);
		$expire_file = $time_file + $this->days_unxstmp($days);
		//verifica se a validade(dias)
		if( $expire_file > time() ){
			$this->rm_file($file);
			return false;
		}else{
			return true;
		}
	}
	
	private function time_after($days=1)
	{
		return time() + $this->days_unxstmp($days);
	}
	
	private function time_before($days=1)
	{
		return time() - $this->days_unxstmp($days);
	}

	
	private function days_unxstmp($days=1)
	{
		return intval($days) * 24 * 60 * 60;
	}
	
	private function rm_file($file)
	{
		return @unlink($file);
	}
	
	
}