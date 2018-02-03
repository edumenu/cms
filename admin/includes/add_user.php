<?php
//Obtaining values from each form
 if(isset($_POST['create_user'])){
   
     $user_firstname = escape($_POST['user_firstname']);
     $user_lastname = escape($_POST['user_lastname']);
     $user_role = escape($_POST['user_role']);
     $username = escape($_POST['username']);
     $user_email = escape($_POST['user_email']);
     $user_password = escape($_POST['user_password']);
     
    //Escaping special characters in a string
    $username = mysqli_real_escape_string($connection, $username);
    $user_password = mysqli_real_escape_string($connection, $user_password);
     
    //first parameter = password
    //Second parameter = algorithm
    //cost is the amount of time it takes a function to give you a new hash
     $user_password = password_hash( $user_password, PASSWORD_BCRYPT, array('cost' => 12));
     
     
     $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) ";
     
     $query .= "VALUES('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_role}')";
     
     $create_user_query = mysqli_query($connection, $query);
     
     confirmQuery($create_user_query);
     
     echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
     User created: <a href='users.php' class='alert-link'>{$user_firstname} {$user_lastname} </a></div>";
     
 }

?>




<form action="" method="post" enctype="multipart/form-data">
   
    <div class="form-group">
        <label for="title">Firstname</label>
          <input type="text" class="form-control" name="user_firstname">
    </div>
    
    <div class="form-group">
        <label for="title">Lastname</label>
          <input type="text" class="form-control" name="user_lastname">
    </div>
    
    <div class="form-group">
    <select name="user_role" id="">
    <option value="subscriber">Select options</option>
    <option value="admin">Admin</option>
    <option value="subscriber">Subscriber</option>
          

    </select>
    </div> 
    
<!--
    <div class="form-group">
        <label for="title"></label>
          <input type="file" name="image">
    </div>
-->
    
    <div class="form-group">
        <label for="title">Username</label>
          <input type="text" class="form-control" name="username">
    </div>
    
    <div class="form-group">
        <label for="title">Email</label>
         <input type="email" class="form-control" name="user_email">
    </div>
       
       <div class="form-group">
        <label for="title">Password</label>
         <input type="password" class="form-control" name="user_password">
    </div>
    
    <div class="form-group">
          <input type="submit" class="btn btn-danger" name="create_user" value="Add User">
    </div>

</form>