<?php

	$host = "localhost";
	$db_name = "DATABASE_NAME";
	$user = "USERNAME";
	$password = "PASSWORD";

	try 
	{
		global $dbc;
		$dbc = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);  
	}  
	catch(PDOException $e)
	{  
		    echo $e->getMessage();  
	}  

?>