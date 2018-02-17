<?php

//Obtaining the id of the selected post to be edited 
if(isset($_GET['p_id'])){
    
  $the_post_id = escape($_GET['p_id']);
    
}


//Find all categories query
$stmt = mysqli_prepare($connection, "SELECT post_id, post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status FROM posts WHERE post_id = ?");

//Checking for errors
confirmQuery($stmt);

mysqli_stmt_bind_param($stmt, "i", $the_post_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $post_id, $post_category_id, $post_title, $post_user, $post_date, $post_image, $post_content, $post_tags, $post_comment_count, $post_status);

while(mysqli_stmt_fetch($stmt)){

}


//Updating in the database by send the values in the fields 
if(isset($_POST['update_post'])){
    
     $post_title = escape($_POST['title']);
     $post_category_id = escape($_POST['post_category']);
     $post_user = escape($_POST['post_user']);
     $post_status = escape($_POST['post_status']);
     
     $post_image = escape($_FILES['image']['name']);
     //Saving the image in a temporary location in the server
     $post_image_temp = escape($_FILES['image']['tmp_name']);
     
     $post_tags = escape($_POST['post_tags']);
     $post_content = escape($_POST['post_content']);
  
     //This function will move the uploaded image from the temp location to the location we want 
     move_uploaded_file($post_image_temp, "../images/$post_image");
    
    //Checking to see if the post image is empty, if it is, it will be retrieved from the database
    if(empty($post_image)){
        
        $stmt = mysqli_prepare($connection, "SELECT post_image FROM posts WHERE post_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $the_post_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$post_image);

        confirmQuery($stmt);


        while(mysqli_stmt_fetch($stmt)){

        }
    }    
    
    $stmt = mysqli_prepare($connection, "UPDATE posts SET post_category_id = ?, post_title = ?, post_user = ?, post_date = now(), post_image = ?, post_content = ?,
    post_tags = ?, post_status = ? WHERE post_id = ?");
    mysqli_stmt_bind_param($stmt, "issssssi", $post_category_id, $post_title, $post_user, $post_image, $post_content, $post_tags, $post_status, $post_id);
    mysqli_stmt_execute($stmt);

    confirmQuery($stmt);

    mysqli_stmt_close($stmt);
    
    
     echo "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Post Updated: " . "<a href='../post.php?p_id={$the_post_id}' class='alert-link'>{$post_title}</a> or <a href='posts.php' class='alert-link'>Edit more posts</a></div>";
    
}

?>   
    

  
<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="title">Post Title</label>
      <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
</div>

<div class="form-group">
    <label for="title">Categories: </label>
    <select name="post_category" id="">    
        <?php
        //Obtain categories from database 
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

<!--
<div class="form-group">
    <label for="title">Post Author</label>
      <input value="<?php echo $post_user; ?>" type="text" class="form-control" name="author">
</div>
-->



 <div class="form-group">
   <label for="users">Users: </label>
    <select name="post_user" id="">
    <?php echo "<option value='$post_user'>{$post_user}</option>"?>
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
 <label for="title">Post Status: </label>
 <select name="post_status" id=""> 
     <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
        <!--  Giving the user the chance to choose between roles  -->
    <?php
    if($post_status == 'published'){
        
    echo "<option value='draft'>Draft</option>";
        
    }else if($post_status == 'draft'){
        
        echo "<option value=published>Published</option>";
    }else{
        //Display both options when status is empty
        echo "<option value=published>Published</option>";
        echo "<option value=draft>Draft</option>";
    }
        
    ?>

    </select>
</div>

<div class="form-group">
    <img src="../images/<?php echo $post_image; ?>" width='100'>
    <input type="file" name="image">
</div>


<div class="form-group">
    <label for="title">Post Tags</label>
      <input value="<?php echo  $post_tags; ?>" type="text" class="form-control" name="post_tags">
</div>

<div class="form-group">
    <label for="title">Post Content</label>
    <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"> <?php echo $post_content; ?>
    </textarea>
</div>


 <script>
      $('#summernote').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 100
      });
    </script>


<div class="form-group">
      <input type="submit" class="btn btn-danger" name="update_post" value="Update Post">
</div>

</form>

<?php ?>
