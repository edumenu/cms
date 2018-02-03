<?php
//This function escapes special characters in a string in order to be used in SQL statement 
function escape($string){
    
    global $connection;
    
return mysqli_real_escape_string($connection, trim($string));
    
}

?>