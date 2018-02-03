<?php

if(isset($_GET['edit_user'])){
    //Obtaining the user's id when you select "edit" in the user's row
     $the_user_id = escape($_GET['edit_user']);
    

    //Displaying the users information in the fields after selecting which user to select.
    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users_query = mysqli_query($connection,$query);
    

    while($row = mysqli_fetch_assoc($select_users_query)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    
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
        
        $query_password = "SELECT * FROM users WHERE user_id = $the_user_id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);
        
        $row = mysqli_fetch_array($get_user_query);
        
        $db_user_password = $row['user_password'];
        
     
        if($db_user_password != $user_password){
        
    //first parameter = password
    //Second parameter = algorithm
    //cost is the amount of time it takes a function to give you a new hash}
     $hashed_password = password_hash( $user_password, PASSWORD_BCRYPT, array('cost' => 12));
        
    }
        
    //Query to update to the selected posted
    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$hashed_password}' ";
    $query .= "WHERE user_id = {$the_user_id} ";
    
    
    $edit_user_query = mysqli_query($connection,$query);
    
    confirmQuery($edit_user_query);   
        
    echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    User updated: <a href='users.php' class='alert-link'>{$user_firstname} {$user_lastname} </a></div>";
        
        
    }
     
    //header("Location: users.php"); //This will refresh the page
     
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