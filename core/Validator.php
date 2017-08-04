<?php
namespace wapi\core;

use wapi\handlers\ErrorHandler;


/**
 * Validator
 */
class Validator
{
    /**
     * Validation
     */
    private final function __construct()
    {

    }

    public static function formValidation($post){
    	//field validation counter
    	$fields = 0;
    	//connection to mysql
    	$mysqli = self::dbConnection();


    	//creating variables based on post key values
    	foreach ($post as $k => $v) {
    		$$k = $mysqli->real_escape_string(trim($v));
    	}

    	//code repetition for field validation for now

    	if(strlen($title) >=5 && strlen($title) <=50){
			//checking for duplicated names - title must be unique    		
    		if($result=$mysqli->query('SELECT title FROM books')){
    			if($row=$result->fetch_assoc()){
    				foreach ($row as $k => $value) {
    					if($title !== $value){
    						$fields++;
    					}
    					else {
	    					ErrorHandler::fail(array('Title' => 'Title already exists'));
    					}	
    				}
    			
    			}
    			else {
    				$fields++;
    			}
    			$result->free();
			}
    	}
    	else{
    		ErrorHandler::fail(array('Title' => 'Title must be between 5 and 50 characters'));
    	}

    	if(strlen($author) >=5 && strlen($author) <=50){
    		$fields++;
    	}
    	else{
    		ErrorHandler::fail(array('Author' => 'Author name must be between 5 and 50 characters'));
    	}
    	//publish date formatting into 'yyyymmdd'
    	if(isset($publish_date)){

    		$date=explode('/', $publish_date);
    		if((count($date)==3 && strlen($date[0])==2) && (strlen($date[1])==2 && strlen($date[2])==4))
    		{
    			
    			$publish_date=$date[2].$date[1].$date[0];
    			$fields++;

    		}
    		else{
    			ErrorHandler::fail(array('Publish Date' => $publish_date. ' incorrect format of date - dd/mm/yyyy'));
    		}
    	}
    	else {
    		ErrorHandler::fail(array('Publish Date' => $publish_date.' cannot be empty - format of date: dd/mm/yyyy'));
    	}
    	//checking if the select values have not been modified
    	if(strlen($format)==2 && (strpos($format, 'A4') === 0 || strpos($format, 'A3') === 0)){
    		$fields++;
    	}
    	else {
    		ErrorHandler::fail(array('Format' => $format.' Format must be between A4 and A3.'));
    	}

    	if(ctype_digit($page_count) && $page_count>=5 && $page_count<100000){
    		$fields++;
    	}
    	else {
    		ErrorHandler::fail(array('Page Count' => $page_count.'  Page Count must be between 5 and 100000 pages.'));
    	}

    	if(isset($isbn) && strlen($isbn)>=5 && strlen($isbn)<=30){
    		if($result=$mysqli->query('SELECT isbn FROM books')){
				if($row=$result->fetch_assoc())
				{
	    			foreach ($row as $k => $value) {
	    				if($title !== $value){
	    					$fields++;
	    				}
	    				else {
	    					ErrorHandler::fail(array('ISBN' => 'ISBN must be unique'));
	    				}	
	    			}
				}
				else {
					$fields++;
				}
    			$result->free();
			}
    	}
    	else {
    		ErrorHandler::fail(array('ISBN' => 'ISBN must be between 5 and 30 characters.'));
    	}

    	if(isset($resume) && strlen($resume)>=15){
    		$fields++;
    	}
    	else {
    		ErrorHandler::fail(array('Resume' =>'Resume must be atleast 15 characters.'));
    	}

    	if(isset($_FILES) && count($_FILES)>0){
    		$filename=trim($_FILES['cover']['name']);
    		$fileLocation='../public/assets/books/'.$filename;
    		$cover='/assets/books/'.$filename;
    		if(@getimagesize($_FILES['cover']['tmp_name']) && !file_exists($fileLocation) ){
    			
    			if(strlen($cover) <=250){
	
	    			$fields++;
	    			
    			}
    			else{
    				ErrorHandler::fail(array('Cover' => $filename.' not an image or already exists.'));
    			}
    		}

    		else {
    			ErrorHandler::fail(array('Cover' => $filename.' not an image or already exists.'));
    		}
    		
    	}
    	else{
    		ErrorHandler::fail(array('Cover' => $filename.' was not uploaded.'));
    	}
    	if($fields==8){
    		$data=array(
    			'title' => $title,
    			'author' => $author,
    			'publish_date' => $publish_date,
    			'format' => $format,
    			'page_count' =>$page_count,
    			'isbn' => $isbn,
    			'resume' => $resume,
    			'cover' => $cover
    			);
    		return array($mysqli, $data);
    	}
    	else {
    		return false;
    	}
    }

    public static function loginValidation($post){
    	$fields=true;
    	$mysqli=self::dbConnection();
    	$username = $mysqli->real_escape_string(trim($_POST['username']));
    	$password = $mysqli->real_escape_string(trim($_POST['password']));

    	if(strlen($username)<3 || strlen($username)>50){
    		ErrorHandler::fail(array('login_attempt_username' => 'Username lenght should be above 3 characters'));
    		$fields=false;
    	}
    	if(strlen($password)<5 || strlen($username)>50){
    		ErrorHandler::fail(array('login_attempt_password' => 'Password lenght should be above 5 characters'));
    		$fields=false;
    	}
    	if(!$fields){
    		return false;
    	}
    	return array($mysqli,compact('username','password'));
    }

    public static function dbConnection(){
    	return new \mysqli('localhost', 'root', 'password', 'wapi');
    }
}