<?php
namespace wapi\core;
//based on gatakka autoloading class
class Autoloader{

protected static $_namespace=array();

	private final function __construct(){

	}

	public static function registerAutoload(){
		spl_autoload_register(array('\wapi\\core\\Autoloader','autoload'));
	}

	protected static function autoload($class){
		self::loadClass($class);

	}

	protected static function loadClass($class){
		foreach (self::$_namespace as $k=>$v) {
			if(strpos($class,$k) === 0){
				$f = str_replace('\\', DIRECTORY_SEPARATOR, $class);
				$f = substr_replace($f, $v, 0,strlen($k)).'.php';
				$f = realpath($f);
				if($f && is_readable($f) && is_file($f)){
					require_once $f;
				}
				else{
					throw new Exception('Class cannot be included');
				}
				break;
			}
		}
	}

	public static function registerNamespace($namespace, $path){
		$namespace = trim($namespace);
		if(strlen($namespace)>0){
			if(!$path){
				throw new Exception('Incorrect path to namespace');
			}
			$_path=realpath($path);
			if($_path && is_dir($_path) && is_readable($_path)){
				self::$_namespace[$namespace.'\\']=$_path.DIRECTORY_SEPARATOR;
			}
			else{
				throw new Exception('Unreadable path to namespace');
			}
		}
		else{
			throw new Exception('Incorrect namespace');
		}
	}
}
