<?php
namespace wapi\core;

use wapi\handlers\ErrorHandler;

/**
 * Authentication
 */
class Auth
{
    private function __construct(){
        
    }

    public static function isLogged(){

    	if(isset($_SESSION['username']) && $_SESSION['auth'] == true){
    		return true;
    	}

    	return false;
    }

    public static function attempt(\mysqli $mysqli,array $data){
    	$_data=new DataIterator($data);
    	$_data = $_data->getData();
    	$fields = $_data[0];
    	$values = $_data[1];
    	$field=explode(', ', $fields);
    	$value = explode(', ', $values);
    	$q="SELECT $values FROM users WHERE $field[0] = $value[0] AND $field[1] =$value[1]";
    	if($result=$mysqli->query($q)){
    		if($login=$result->fetch_assoc()){
    			$_SESSION['username'] = $login['user'];
    			$_SESSION['auth'] = true;
    			$result->free();
    			$mysqli->close();
    			return true;
       		}
    		else {
                header('Location: /login');
    			ErrorHandler::fail(array('Login Attempt' => 'Username/Password combination are incorrect.'));
                return false;
    		}
    	}
    	else {
    		ErrorHandler::fail(array('Login Attempt' => 'Something went wrong with the login, please try again in a few seconds.'));
            return false;
    	}

    }
}