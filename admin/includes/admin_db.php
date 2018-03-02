<?php ob_start();?> <!-- Output buffering -->
<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

//Database information
$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "root";
$db['db_name'] = "cms";

foreach($db as $key => $value){
    
    //defining the keys as a constant 
    //changing the key to upper case
    define(strtoupper($key), $value);
    
}

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if($connection){
    
    //echo "We are connected";
    
}else{
    echo "Failed to connect!";
}

?>