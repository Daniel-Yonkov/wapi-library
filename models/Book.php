<?php

namespace wapi\models;

use wapi\core\DataIterator;
use wapi\handlers\ErrorHandler;
use wapi\handlers\SuccessHandler;

/**
 * Book model
 */
class Book
{
    /**
     * Book creation
     */
    public function __construct(\mysqli $mysqli, array $data)
    {
    	//code repetition here
    	$filename=trim($_FILES['cover']['name']);
    	$fileLocation='../public/assets/books/'.$filename;
    	//creating a strings for VALUES
    	$iterator = new DataIterator($data);
    	$_data=$iterator->getData();
    	list($fields, $values) = $_data;
        	if($mysqli->query("INSERT INTO books($fields) VALUES($values)")){
        		move_uploaded_file($_FILES['cover']['tmp_name'], __DIR__.DIRECTORY_SEPARATOR.$fileLocation);
        		SuccessHandler::message(array('Success' => 'Book has been added to the library.'));

        	}
        	else {
        		ErrorHandler::fail(array('Record Failure' => 'Something went wrong recording the book. Contact you IT administrator.'));
        	}
        	$mysqli->close();
    }

    public static function getBooks(\mysqli $mysqli, $page=1, $limit=6, $offset=0){

    			$numRows=self::getRows($mysqli);
    			
    			if($numRows>$offset ||  $offset<0){
    				if($result=$mysqli->query("SELECT title,cover FROM books LIMIT $offset,$limit")){
    					while($_data=$result->fetch_assoc()){
	    					$data[]=$_data;
    					}
    					return $data;
    			}
    			else {
    				ErrorHandler::fail(array('No Result' =>'No results were found in the records.'));
    			}
    		}
    		else {
    			ErrorHandler::fail(array('No Result' => 'There are no results on this page.'));
    		}
    	}

    public static function getRows( \mysqli $mysqli){
    	if($result=$mysqli->query("SELECT COUNT(1) AS num_rows FROM books")){
    			$numRows=$result->fetch_assoc();
    			$result->free();
    			return $numRows['num_rows'];
    	}
    	else {
    		ErrorHandler::fail(array('No Result' =>'No results were found in the records.'));
    		$result->free();
    	} 
    	
    }
}