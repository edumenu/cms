<?php include "includes/admin_header.php"; ?>
   
<?php
//Checking for the session 
if(isset($_SESSION['username'])){
    
    //Obtaining the current user's information using the username
    $username = escape($_SESSION['username']);
    
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    
    $select_user_profile_query = mysqli_query($connection, $query);
    
    while($row = mysqli_fetch_array($select_user_profile_query)){
        
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        //$user_image = $row['user_image'];
        $user_role = $row['user_role'];
    } 
}

?>

    
<?php

//Obtaining values from each form
 if(isset($_POST['edit_user'])){
     
     //$user_id = $_POST['user_id'];
     $user_firstname = escape($_POST['user_firstname']);
     $user_lastname = escape($_POST['user_lastname']);
     $user_role = escape($_POST['user_role']);
     
//     $post_image = $_FILES['image']['name'];
//     //Saving the image in a temporary location in the server
//     $post_image_temp = $_FILES['image']['tmp_name'];
     
     $username = escape($_POST['username']);
     $user_email = escape($_POST['user_email']);
     $user_password = escape($_POST['user_password']);
     //Sending the date with the function "date in the d-m-y" format
     //$post_date = date('d-m-y');
     
     //This function will move the uploaded image from the temp location to the location we want  
     //move_uploaded_file($post_image_temp, "../images/$post_image");
     
     
    //Query to update to the selected posted
    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$user_password}' ";
    $query .= "WHERE username = '{$username}'";
    
    
    $edit_user_query = mysqli_query($connection,$query);
    
    confirmQuery($edit_user_query);
    header("Location: users.php"); //This will refresh the page
     
 }

?>                                              

<div id="wrapper">
        
       
       <?php include "includes/admin_navigation.php"?>
        
    <div id="page-wrapper">

     <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">

               <h1 class="page-header">
                    Welcome to Admin
                    <small>Author</small>
                </h1>

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

                    echo "<option value='subscriber'>subscriber</option>";

                    }else{

                    echo "<option value='admin'>admin</option>";
                    }   

                    ?>

                </select>
                </div> 

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
                    <input type="submit" class="btn btn-danger" name="edit_user" value="Update Profile">
                </div>

                </form>
                
            </div>
        </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
            
            
<?php include "includes/admin_footer.php"; ?>
