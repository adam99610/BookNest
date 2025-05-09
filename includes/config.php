<?php
//Database configuration

if (!defined('DB_SERVER')){
    define('DB_SERVER', 'localhost');
}
if (!defined('DB_USERNAME')){
    define('DB_USERNAME', 'root');
}
if (!defined('DB_PASSWORD')){
    define('DB_PASSWORD', 'root');
}
if (!defined('DB_NAME')){
    define('DB_NAME', 'booknest');
}

//Attempt to connect to MySQL database
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

//Check the connection
if($mysqli->connect_error){
    die("ERROR: Could not connect. " . $mysqli->connect_errno);

}
?>