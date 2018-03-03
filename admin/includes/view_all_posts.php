<?php

//Checking to see if there are any values in the check box array
if(isset($_POST['checkBoxArray'])){
    
     $counter = 1;
    
    //Assigning the arrays in the check box 
   foreach($_POST['checkBoxArray'] as $postvalueId){
       
       
       //Obtaining the value selected in the options dropdown
        $bilk_options = $_POST['bilk_options'];
       
       //Applying changes to the post based on the option selected
       switch($bilk_options){
            
            //If the option selected is published, send this query
           case 'published':
                $stmt = mysqli_prepare($connection, "UPDATE posts SET post_status = ? WHERE post_id = ?");
                mysqli_stmt_bind_param($stmt, "si", $bilk_options, $postvalueId);
                mysqli_stmt_execute($stmt);
                confirmQuery($stmt);
               
               if($counter == 1){
              echo "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Update successful!</div>";
                   
               $counter = $counter + 1;
               
               }
               break;
               
            //If the option selected is draft, send this query   
            case 'draft':
                $stmt = mysqli_prepare($connection, "UPDATE posts SET post_status = ? WHERE post_id = ?");
                mysqli_stmt_bind_param($stmt, "si", $bilk_options, $postvalueId);
                mysqli_stmt_execute($stmt);
                confirmQuery($stmt);
               
               if($counter == 1){
               echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Update successful!</div>";
                   $counter = $counter + 1;
               
               }
               break;
               
            //If the option selected is delete, send this query   
            case 'delete':
               $stmt = mysqli_prepare($connection, "DELETE FROM posts WHERE post_id = ?");
                mysqli_stmt_bind_param($stmt, "i", $postvalueId);
                mysqli_stmt_execute($stmt);
                confirmQuery($stmt);
               
               
                if($counter == 1){
               echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Delete successful!</div>";
               $counter = $counter + 1;
               
               }
               break;
               
               
            //If the option selected is clone, send this query   
            case 'clone':
                //Obtaining the details to each posts
               $stmt = mysqli_prepare($connection, "SELECT post_category_id, post_title, post_author, post_user, post_date, post_image, post_content, post_tags, post_status FROM posts WHERE post_id = ?");
               //Checking for errors
               confirmQuery($stmt);

               mysqli_stmt_bind_param($stmt, "i", $postvalueId);
               mysqli_stmt_execute($stmt);
               mysqli_stmt_bind_result($stmt, $post_category_id, $post_title, $post_author, $post_user, $post_date, $post_image, $post_content, $post_tags, $post_status);
               
               
                while(mysqli_stmt_fetch($stmt)){

                }
               
               $post_date = date('d-m-y');
               $stmt2 = mysqli_prepare($connection, "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_image, post_content, post_tags, post_status) VALUES(?,?,?,?,?,?,?,?,?)");
               mysqli_stmt_bind_param($stmt2, "isssissss", $post_category_id, $post_title, $post_author, $post_user, $post_date, $post_image, $post_content, $post_tags, $post_status);
               mysqli_stmt_execute($stmt2);
               //Checking for errors
               confirmQuery($stmt2);
               
               if($counter == 1){
               echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Clone successful!</div>";
               $counter = $counter + 1;
               }
               break;
               
               //If the option selected is clone, send this query   
           case 'reset':
              $stmt = mysqli_prepare($connection, "UPDATE posts SET post_views_count = 0 WHERE post_id = ?");
              mysqli_stmt_bind_param($stmt, "i", $postvalueId);
              mysqli_stmt_execute($stmt);
               //Checking for errors
               confirmQuery($stmt);
               
               
               if($counter == 1){
               echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Reset successful!</div>";
               $counter = $counter + 1;
               }
               break;           
       }
   }  
}
?>

<form action="" method="post"> 

<table class = "table table-bordered table-hover">

   <div id="bulkOptionContainer" class="col-xs-4">
       <!-- Adding a select option -->
       <select class="form-control" name="bilk_options" id="">

           <option value="">Select Options</option>
           <option value="published">Published</option>
           <option value="draft">Draft</option>
           <option value="delete">Delete</option>
           <option value="clone">Clone</option>
           <option value="reset">Reset Views</option>

       </select>

   </div>
       
   <div class="col-xs-4">
<!-- Adding an input and an anchor tag  -->
   <input type="submit" name="submit" class="btn btn-success" value="Apply">
   <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
   
   </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Post Id</th>
                <th>Category</th>
                <th>Title</th>
                <th>User</th>
                <th>Date</th>
                <th>Image</th>
                <th>Post Content</th>
                <th>Post Tags</th>
                <th>Post Comment Count</th>
                <th>Post Status</th>
                <th>Number of views</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
    <tbody>
    <?php
            
        //Checking for a get request called page and assigning it to a variable
        if(isset($_GET['page'])){

        $page = escape($_GET['page']);

        }else{
        //Assign the page to empty if get reuest doesn't exist
        $page = "";

        }

        //Checking if the page is either null or 1 then assigning it to 0
        if($page == "" || $page == 1){

            $page_1 = 0;


        }else{
            //If page is greater than 1 multiple ny 5 and divide by 5
            $page_1 = ($page * 5 ) - 5;
        }

        $select_query_count = "SELECT * FROM posts"; 
        $find_count = mysqli_query($connection,$select_query_count);
        //Counting the number of rows int he table
        $count = mysqli_num_rows($find_count);

        $count = ceil($count / 5);     

        $query = "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_user, posts.post_date, posts.post_image, posts.post_content, "; 
        $query .= "posts.post_tags, posts.post_comment_count, posts.post_status, posts.post_views_count, categories.cat_title, categories.cat_id ";
        $query .= "FROM posts ";
        $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC LIMIT $page_1,10";
            
        $select_posts = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_posts)){
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_user = $row['post_user'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
        $post_views_count = $row['post_views_count'];
        $category_title = $row['cat_title'];
        $category_id = $row['cat_id'];
        
        echo "<tr>";
        
        ?>
        <!-- The check array stores the id's of the posts you want to delete -->
        <td><input class='checkBoxes' name='checkBoxArray[]' type='checkbox' value='<?php echo $post_id ?>'></td>
        
        <?php
        
        echo "<td>$post_id</td>";
        
        echo "<td>{$category_title}</td>";

        echo "<td>$post_title</td>";
                
          if(!empty($post_author)){
              
             echo "<td>$post_author</td>"; 
          }elseif(!empty($post_user)){
             echo "<td>$post_user</td>"; 
          }    
            
        echo "<td>$post_date</td>";
        echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
        echo "<td>$post_content</td>";
        echo "<td>$post_tags</td>";
        
        //Counting the number of comments on each post            
        $stmt = mysqli_prepare($connection, "SELECT * FROM comments WHERE comment_post_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $count_comments = mysqli_stmt_num_rows($stmt);
        //Checking for errors
        confirmQuery($stmt);
            
        echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";
        echo "<td>$post_status</td>";
        echo "<td><a class='btn btn-info' href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
        echo "<td><a class='btn btn-success' href='../post.php?p_id={$post_id}'>View Post</<a></td>";
        echo "<td><a class='btn btn-primary' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</<a></td>";
        echo "<td><a id='$post_title' rel='$post_id' href='javascript:void(0)' class='btn btn-danger delete_link'>Delete</a></td>"; //it the result is undefined, the browser stays on the same page
        echo "</tr>";
    }

    ?>

    </tbody>
        
</table>

<hr>

<ul class="pager">

<?php
    
     for($i = 1; $i <= $count; $i++){
            
         //Adding 
         if($i == $page){
             
             echo "<li><a class='active_link' href='posts.php?page={$i}'>{$i}</a></li>";
             
         }else if($page == ""){
             $page = 1;
             echo "<li><a class='active_link' href='posts.php?page={$i}'>{$i}</a></li>";
             
         }else{
          
             echo "<li><a href='posts.php?page={$i}'>{$i}</a></li>"; 
         }
    } 
?>

</ul>

</form>  

<?php

if(isset($_POST['delete'])){
    
    //Making sure only admin users can delete posts
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){
            
    $the_post_id =  escape($_POST['post_id']);
            
    $stmt = mysqli_prepare($connection, "DELETE FROM posts WHERE post_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $the_post_id);
    mysqli_stmt_execute($stmt);
    //Checking for errors
    confirmQuery($stmt);  

    header("Location: posts.php"); //This will refresh the page
            
        }
    
     } 
}

?>


<?php

if(isset($_GET['reset'])){
    
    //Making sure only admin users can reset posts
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){
    
   $the_post_id = escape($_GET['reset']);
            
    $stmt = mysqli_prepare($connection, "UPDATE posts SET post_views_count = 0 WHERE post_id =?");
    mysqli_stmt_bind_param($stmt, "i", $the_post_id);
    mysqli_stmt_execute($stmt);
    //Checking for errors
    confirmQuery($stmt);               
            
    header("Location: posts.php");
            
        }
        
    }
    
}

?>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-sm">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm deletion</h4>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Are you sure you want to delete <b><span id="title" value=""></span></b>?</h3>
      </div>
      <div class="modal-footer">        
          
     <form method="post">
         
             <button type="button" class="btn btn-default pull right" data-dismiss="modal">Cancel</button>  
            
            <input id="modal_delete_link" type="hidden" name="post_id" value="" >
            
            <button type='submit' name='delete' value='Delete' class='btn btn-danger'>Delete</button>
         
     </form> 
          
      </div>
    </div>
    </div>
  </div>
</div>


<script>

//Adding a modal to to the delete link
$(document).ready(function(){
    
    $(".delete_link").on('click', function(){

        var id = $(this).attr("rel");  //Obtaining the post id from rel attribute
        
        var title = $(this).attr("id");
        
        $("#myModal").modal('show');    //Display the modal
        
           document.getElementById('title').innerHTML = title;
          document.getElementById('modal_delete_link').setAttribute("value",id);  //Set post id to the attribute value 
    });
    
});

</script>








