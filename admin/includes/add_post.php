<?php
//Obtaining values from each form
 if(isset($_POST['create_post'])){
   
     $post_title = escape($_POST['title']);
     $post_category_id = escape($_POST['post_category']);
     $post_user = escape($_POST['post_user']);
     $post_status = escape($_POST['post_status']);
     
     $post_image = escape($_FILES['image']['name']);
     //Saving the image in a temporary location in the server
     $post_image_temp = escape($_FILES['image']['tmp_name']);
     
     $post_tags = escape($_POST['post_tags']);
     $post_content = escape($_POST['post_content']);
     //Sending the date with the function "date in the d-m-y" format
     $post_date = date('d-m-y');
     
     //This function will move the uploaded image from the temp location to the location we want 
     move_uploaded_file($post_image_temp, "../images/$post_image");
     
     //used to execute the same (or similar) SQL statements repeatedly with high efficiency
     //mysqli_prepare for more security
     $stmt = mysqli_prepare($connection, "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) VALUES(?,?,?,?,?,?,?,?)");
     
    mysqli_stmt_bind_param($stmt, "isssssss", $post_category_id, $post_title, $post_user, $post_date, $post_image, $post_content, $post_tags, $post_status);
    mysqli_stmt_execute($stmt);

    confirmQuery($stmt);

    mysqli_stmt_close($stmt);
     
     echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
     {$post_title} has been added successfully!</div>";
     
 }
?>


<form action="" method="post" enctype="multipart/form-data">
   
    <div class="form-group">
        <label for="title">Post Title</label>
          <input type="text" class="form-control" name="title">
    </div>
    
    <div class="form-group">
      <label for="title">Categories</label>
        <select name="post_category" id="">

            <?php
           //Displaying categoreis from the database
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            confirmQuery($select_categories);

            while($row = mysqli_fetch_assoc($select_categories)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

             echo "<option value='$cat_id'>{$cat_title}</option>";

            }

            ?>

        </select>
    </div> 
   
   <div class="form-group">
   <label for="users">Users</label>
    <select name="post_user" id="">
           
        <?php

        $users_query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $users_query);
        
        confirmQuery($select_users);

        while($row = mysqli_fetch_assoc($select_users)){
        $user_id = $row['user_id'];
        $username = $row['username'];
           
         echo "<option value='$username'>{$username}</option>";
            
        }

        ?>

    </select>
   </div> 
    
    <div class="form-group">
        <label for="post_status">Post Status</label><br>
          <select name="post_status" id="">
              <option value="draft"> Post Status</option>
              <option value="published"> Published</option>
              <option value="draft"> Draft</option>
          </select> 
    </div>
    
    <div class="form-group">
        <label for="title">Post Image</label>
          <input type="file" name="image">
    </div>
    
    <div class="form-group">
        <label for="title">Post Tags</label>
          <input type="text" class="form-control" name="post_tags">
    </div>
    
    <div class="form-group">
        <label for="title">Post Content</label>
        <textarea id="summernote" class="form-control" name="post_content" cols="30" rows="10"></textarea>
    </div>

      <script>
      $('#summernote').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 100
      });
    </script>
   
    
    <div class="form-group">
          <input type="submit" class="btn btn-danger" name="create_post" value="Publish Post">
    </div>

</form>