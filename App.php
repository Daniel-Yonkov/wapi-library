<?php
namespace wapi;
use wapi\core\Autoloader;
use wapi\core\Router;
use wapi\handlers\SessionHandler;

require_once 'core/Autoloader.php';

class App {

	private static $_instance=null;

	private function __construct(){
		Autoloader::registerNamespace('wapi',__DIR__);
		Autoloader::registerAutoload();
		SessionHandler::start();
		$router = new Router();
	}

	public static function getInstance(){
		if(self::$_instance === null){
			self::$_instance = new App();
		}
		return self::$_instance;
	}

}
