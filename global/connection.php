<?php

include('config.php');

$server = "mysql:dbname=".DB.";host=".SERVER;

try{
	$pdo = new PDO($server, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
}catch(PDOException $e){
	echo 'ERROR: '.$e;
}

?>