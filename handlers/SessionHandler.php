<?php
namespace wapi\handlers;
class SessionHandler{

	private final function __construct(){

	}

	public static function start(){
		session_name('WapiLibrary');
		session_start();
	}

	public static function destroy(){
		session_name('WapiLibrary');
		session_start();
		$_SESSION=array();
		if (ini_get("session.use_cookies")) {
 		   $params = session_get_cookie_params();
    		setcookie(session_name(), '', time() - 42000,
        		$params["path"], $params["domain"],
        		$params["secure"], $params["httponly"]
    		);
		}
		session_destroy();
	}
}