<?php
namespace wapi\core;

use wapi\controllers\ControllerGet;
use wapi\handlers\SessionHandler;
use wapi\models\Book;

class Router {
	
	protected $availableRoutesGet=array(
		'/' => '../view/main-page.php',
		'/login' => '../view/login.php', 
		'/library' => '../view/library.php');
	protected $libraryPage = null;
	protected $availableRoutesPost=array('/login','/');
	protected $errorPage='../view/404.php';
	protected $logoff='/logout';
	protected $url;


	public function __construct(){

	$this->url = trim($_SERVER['REQUEST_URI']);
	if(strlen($this->url)>1 && substr($this->url, -1) === '/'){
		$_url = substr($this->url, 0, -1);
		header('Location: '.$_url);
		die();
	}
	$this->route();
	}

	protected function route(){
		if(trim($_SERVER['REQUEST_METHOD'])==='GET')
		{
			$this->constructRoute($this->url);
			if(array_key_exists($this->url, $this->availableRoutesGet)){
				switch ($this->url) {
					case '/':
						ControllerGet::index($this->availableRoutesGet[$this->url]);
						break;
					case '/login':
						ControllerGet::login($this->availableRoutesGet[$this->url]);
						break;
					case '/library':
						ControllerGet::library($this->availableRoutesGet[$this->url]);
						break;
					case $this->libraryPage:
						ControllerGet::library($this->availableRoutesGet[$this->url]);
						break;
				}
				// require_once $this->availableRoutesGet[$this->url];
			}

			elseif($this->url == $this->logoff){
				//if is logged -> else to the error page
				SessionHandler::destroy();
				header('Location: /');
			}

			else {
				$this->errorRoute();
			}
		}

		if(trim($_SERVER['REQUEST_METHOD'])==='POST')
		{

			//skiping creation of POST controller
			if(in_array($this->url, $this->availableRoutesPost))
			{
				switch ($this->url) {
					case $this->availableRoutesPost[0]:
						if($data=Validator::loginValidation($_POST)){
							list($mysqli, $login) = $data;
							if(Auth::attempt($mysqli, $login)){
								header('Location: /');
							}
							else {
								header('Location: /login');
							}

						}
						else {
							header('Location: /login');
							die();
						}
						break;
					case $this->availableRoutesPost[1]:
						if($_data=Validator::formValidation($_POST)){
							list($mysqli, $data) = $_data;
							new Book($mysqli, $data);
							header('Location: /');
							die();
							
						}
						else {
							header('Location: /');
							die();
						}

						break;
					default:
						$this->errorRoute();
						break;
				}
			}
			
		}
	}

	protected function constructRoute($url){
		if(preg_match('/\/library\/[0-9]+\b$/', $url,  $book)){
			require_once '../view/book.php';
			// $this->availableRoutesGet[$book[0]]='../view/book.php';
		}
		if(preg_match('/\/library\?page=[1-9]+$/', $url,$libraryPage)){
			$this->availableRoutesGet[$libraryPage[0]]='../view/library.php';
			$this->libraryPage = $libraryPage[0];
		}
		
	}

	protected function errorRoute(){
		require_once $this->errorPage;
		exit;
	}

}