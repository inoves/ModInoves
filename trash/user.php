<?php
class User extends ActiveRecord\Model {
	
	var $new_password;
	var $err_msg = '';
	
	
	public function before_save()
	{
		if(!$this->valid()) //not valid
			throw new Exception($this->err_msg);
			
		if ($this->new_password):
			$this->password = MD5($this->new_password);
		endif;
	}
	
	function valid() //Valida todos os campos
	{
		$this->err_msg = $this->err_msg . $this->valid_username();
		if(is_null($this->name) ) 
			$this->err_msg = $this->err_msg . 'Name required<br>';
		
		return ($this->err_msg=='');
	}
	
	function permission($controller=false, $action=false, $group_id=null){
		if($group_id==null)
			$group_id = $this->group_id;
		
		if($group_id==Config::$admin_group_id) return true; //admin group priority 
		
		$per = Permission::find('first', array('conditions'=>'group_id='.$group_id.' AND controller=\''.$controller.'\' AND action=\''.$action.'\''));
		if($per){
			return true;
		}
		return false;
	}
	
	private function valid_username()
	{
		if (is_null($this->username) || $this->username == ""):
			return 'Username required<br/>';
		elseif(strlen($this->username)<3):
			return 'Username minimun length required<br/>';
		endif;
		return null;
	}
	
	static function current_user() {
		return unserialize(Session::get('current_user'));
	}
	
	static function logged(){
		return self::current_user();
	}
	
	static function login($username, $password){
		$current_user = self::find('first', array('conditions'=>'username='.ActiveRecord::quote($username).' AND password='.ActiveRecord::quote(MD5($password))));
		if ($current_user):
			Session::set('current_user', serialize($current_user));
			return true;
		endif;
		return false;
	}
}