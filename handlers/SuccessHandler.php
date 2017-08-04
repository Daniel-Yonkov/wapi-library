<?php
namespace wapi\handlers;

class SuccessHandler{

	private function __construct(){

	}

	public static function message(array $message){
		$key=key($message);
		$_SESSION['success']=$message[$key];
	}
}
