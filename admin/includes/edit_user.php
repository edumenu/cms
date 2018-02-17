<?php

if(isset($_GET['edit_user'])){
    //Obtaining the user's id when you select "edit" in the user's row
     $the_user_id = escape($_GET['edit_user']);
    

    //Displaying the users information in the fields after selecting which user to edit
    $stmt = mysqli_prepare($connection, "SELECT user_id, username, user_password, user_firstname, user_lastname, user_email, user_image, user_role FROM users WHERE user_id = ?");

    //Checking for errors
    confirmQuery($stmt);

    mysqli_stmt_bind_param($stmt, "i", $the_user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $username, $user_password, $user_firstname, $user_lastname, $user_email, $user_image, $user_role);

    while(mysqli_stmt_fetch($stmt)){

    }
    
?>

<?php


//Obtaining values from each form
 if(isset($_POST['edit_user'])){
   
     $user_firstname = escape($_POST['user_firstname']);
     $user_lastname = escape($_POST['user_lastname']);
     $user_role = escape($_POST['user_role']);
     $username = escape($_POST['username']);
     $user_email = escape($_POST['user_email']);
     $user_password = escape($_POST['user_password']);
     
    if(!empty($user_password)){
        
        $stmt = mysqli_prepare($connection, "SELECT user_password FROM users WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $the_user_id);
        mysqli_stmt_execute($stmt);
        confirmQuery($stmt);
        mysqli_stmt_bind_result($stmt, $db_user_password);
        
         while(mysqli_stmt_fetch($stmt)){

         }
        
        
        mysqli_stmt_close($stmt);
        
        if($db_user_password != $user_password){

        //first parameter = password
        //Second parameter = algorithm
        //cost is the amount of time it takes a function to give you a new hash}
         $hashed_password = password_hash( $user_password, PASSWORD_BCRYPT, array('cost' => 12));
            
         //Query to update user's info when password hasn't been provided
        $stmt = mysqli_prepare($connection, "UPDATE users SET user_firstname = ?, user_lastname = ?, user_role = ?, username = ?, user_email = ?, user_password = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $user_firstname, $user_lastname, $user_role, $username, $user_email, $hashed_password, $the_user_id);
        mysqli_stmt_execute($stmt);

        confirmQuery($stmt);

        mysqli_stmt_close($stmt);
            
            

         }else{
            
         //Query to update user's info when password isn't the same as the one in the database    
         $stmt = mysqli_prepare($connection, "UPDATE users SET user_firstname = ?, user_lastname = ?, user_role = ?, username = ?, user_email = ?, user_password = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $user_firstname, $user_lastname, $user_role, $username, $user_email, $user_password, $the_user_id);
        mysqli_stmt_execute($stmt);

        confirmQuery($stmt);

        mysqli_stmt_close($stmt);    
            
        }
        
          }else{
        
        //Query to update user's info when password hasn't been provided
        $stmt = mysqli_prepare($connection, "UPDATE users SET user_firstname = ?, user_lastname = ?, user_role = ?, username = ?, user_email = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "sssssi", $user_firstname, $user_lastname, $user_role, $username, $user_email, $the_user_id);
        mysqli_stmt_execute($stmt);

        confirmQuery($stmt);

        mysqli_stmt_close($stmt);
        
        
        
    }
           
        
    echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    User updated: <a href='users.php' class='alert-link'>{$user_firstname} {$user_lastname} </a></div>";

 }
    

}else{
    
    header("Location: index.php");
}

?>


<form action="" method="post" enctype="multipart/form-data">
   
    <div class="form-group">
        <label for="title">Firstname</label>
          <input type="text" class="form-control" value="<?php echo $user_firstname?>" name="user_firstname">
    </div>
    
    <div class="form-group">
        <label for="title">Lastname</label>
          <input type="text" class="form-control" value="<?php echo $user_lastname?>" name="user_lastname">
    </div>
    
    <div class="form-group">
    
    <select name="user_role" id="">
    
    <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
    <!--  Giving the user the chance to choose between roles  -->
    <?php
    if($user_role == 'admin'){
        
    echo "<option value='subscriber'>Subscriber</option>";
        
    }else if($user_role == 'subscriber'){
        
        echo "<option value='admin'>Admin</option>";
    }else{
        //Display both options when user_role is empty
        echo "<option value='admin'>Admin</option>";
        echo "<option value='subscriber'>Subscriber</option>";
    }
        
    ?>

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
          <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
    </div>
    
    <div class="form-group">
        <label for="title">Email</label>
         <input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email">
    </div>
       
       <div class="form-group">
        <label for="title">Password</label>
         <input type="password" class="form-control" value="<?php echo $user_password; ?>"name="user_password">
    </div>
    
    <div class="form-group">
          <input type="submit" class="btn btn-danger" name="edit_user" value="Update User">
    </div>

</form>