<?php

//first parameter = password
//Second parameter = algorithm
//cost is the amount of time it takes a function to give you a new hash 
echo password_hash('secret', PASSWORD_BCRYPT, array('cost' => 12));




?>