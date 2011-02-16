<?php
class Customer extends ActiveRecord\Model {
	
	/**
	 * 
	 */
	static function login($username, $password){
		return false;
	}
	
	/**
	 * 
	 */
	static function logout(){
		return false;
	}
	
	/**
	 * Get e set customer in session
	 */
	static function current($customer=false){
		if($customer)
			return Session::set(Config::$session_customer, $customer);
	}
}

