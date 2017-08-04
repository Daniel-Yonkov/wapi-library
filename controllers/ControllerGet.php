<?php
namespace wapi\controllers;

use wapi\core\Auth;
use wapi\core\Validator;
use wapi\models\Book;

/**
 * Controller for GET queries
 */
class ControllerGet
{
    /**
     * GET method controller
     */


    private function __construct()
    {
 		
    }

    public static function index($view){
    	$isLogged=Auth::isLogged();
    	require_once $view;
    	$_SESSION['errors']=array();
    }

    public static function login($view){
    	if(!Auth::isLogged()){
    		require_once $view;	
    	}
    	else {
    		header('Location: /');
    		die();
    	}
    }

    public static function library($view){
    	if(Auth::isLogged()){
	    	$limit=6;
    		$numPages=ceil(Book::getRows(Validator::dbConnection())/$limit);

    		if(isset($_GET['page'])){
    			$page=$_GET['page'];
    			$offset = ($page-1)*$limit;
 				
	    		$data=Book::getBooks(Validator::dbConnection(),$page,$limit,$offset);
    		}
    		else {
    			$data=Book::getBooks(Validator::dbConnection());
    		}
    		require_once $view;
    	}
    	else {
    		header('Location: /login');
    		die();
    	}
    }
}