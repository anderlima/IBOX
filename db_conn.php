<?php 
define('SERVER', 'us-cdbr-sl-dfw-01.cleardb.net');
define('DBNAME', 'ibmx_9db6d0a94c4c716');
define('USER', 'b5141c94decd1e');
define('PASSWORD', '67cd4e542281633');
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

#define('SERVER', 'localhost');
#define('DBNAME', 'ci_box');
#define('USER', 'root');
#define('PASSWORD', '');

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
$db = new PDO("mysql:host=".SERVER."; dbname=".DBNAME, USER, PASSWORD, $options);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL; echo "<br>";
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL; echo "<br>";
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL; echo "<br>";
    exit;
}