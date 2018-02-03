<?php 

include("delete_modal.php");



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
               $query = "UPDATE posts SET post_status = '{$bilk_options}' WHERE post_id = {$postvalueId}";
               
               $update_to_published_status = mysqli_query($connection, $query);
               confirmQuery($update_to_published_status);
               if($counter == 1){
              echo "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Update successful!</div>";
                   
               $counter = $counter + 1;
               
               }
               break;
               
               
            //If the option selected is draft, send this query   
            case 'draft':
               $query = "UPDATE posts SET post_status = '{$bilk_options}' WHERE post_id = {$postvalueId}";
               
               $update_to_draft_status = mysqli_query($connection, $query);
               
               confirmQuery($update_to_draft_status);
               if($counter == 1){
               echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Update successful!</div>";
                   $counter = $counter + 1;
               
               }
               break;
               
            //If the option selected is delete, send this query   
            case 'delete':
               $query = "DELETE FROM posts WHERE post_id = {$postvalueId}";
               
               $update_to_delete_status = mysqli_query($connection, $query);
               
               confirmQuery($update_to_delete_status);
                if($counter == 1){
               echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Delete successful!</div>";
               $counter = $counter + 1;
               
               }
               break;
               
               
            //If the option selected is clone, send this query   
            case 'clone':
               $query = "SELECT * FROM posts WHERE post_id = {$postvalueId}";
               $select_post_query = mysqli_query($connection, $query);
               confirmQuery($select_post_query);
               
                while($row = mysqli_fetch_assoc($select_post_query)){
                        $post_category_id = $row['post_category_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_tags = $row['post_tags'];
                        $post_status = $row['post_status'];
                }
               
               
               $query = "INSERT INTO posts(post_category_id,post_title, post_author,post_user, post_date, post_image, post_content, post_tags, post_status) ";
     
               $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
               
               $copy_query = mysqli_query($connection, $query);
               confirmQuery($copy_query);
               if($counter == 1){
               echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
               Clone successful!</div>";
               $counter = $counter + 1;
               }
               break;
               
               
               //If the option selected is clone, send this query   
               case 'reset':
               $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection,$postvalueId) . " ";
              $update_post_views = mysqli_query($connection,$query);
              confirmQuery($update_post_views);
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
<!--   <a href="posts.php?source=add_post">Add Posts</a>-->
   
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

        //Find all categories query
        $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1,10";
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
        
        echo "<tr>";
        
        
        ?>
        <!-- The check array stores the id's of the posts you want to delete -->
        <td><input class='checkBoxes' name='checkBoxArray[]' type='checkbox' value='<?php echo $post_id ?>'></td>
        
        <?php
        
        
        echo "<td>$post_id</td>";
        
        
        $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
        $select_categories_id = mysqli_query( $connection, $query);

        while($row = mysqli_fetch_assoc($select_categories_id)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        
        
        
        echo "<td>{$cat_title}</td>";
            
        }
        
        
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
        
        //Counting the number of counts on each post
        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
        $send_comment_query = mysqli_query($connection,$query); 
        $count_comments = mysqli_num_rows($send_comment_query);
            
            
        echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";
        echo "<td>$post_status</td>";
        echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>View Post</<a></td>";
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</<a></td>";
        echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>"; //it the result is undefined, the browser stays on the same page
//        echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
        echo "</tr>";
    }

    ?>

        </tbody>
        
        
</table>

<hr>

<ul class="pager">

<?php
//    for($i = 1; $i <= $count; $i++){
//     
//     echo "<ul class='pagination' class='center-block'><li><a href='posts.php?page={$i}'>$i</a></li></ul>";
//        
//    }
    
    
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

if(isset($_GET['delete'])){
    
    //Making sure only admin users can delete posts
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){
            
    $the_user_id =  mysqli_real_escape_string($connection, $_GET['delete']);
    
    
    $the_post_id = ($_GET['delete']);
    
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
    $delete_query = mysqli_query($connection,$query);
    header("Location: posts.php"); //This will refresh the page
            
        }
    
     } 

}

?>


<?php

if(isset($_GET['reset'])){
    
    //Making sure only admin users can delete posts
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){
    
   $the_post_id = $_GET['reset'];
    
   $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection,$_GET['reset']) . " ";
    
     $update_post_views = mysqli_query($connection,$query);
     confirmQuery($update_post_views);
    header("Location: posts.php");
            
        }
        
    }
    
}

?>

<script>

//Adding a modal to to the delete link
$(document).ready(function(){
    
    $(".delete_link").on('click', function(){
        
        var id = $(this).attr("rel");
        
        var delete_url = "posts.php?delete="+ id +" ";
        
        $("#myModal").modal('show');
        
        $(".modal_delete_link").attr("href",delete_url);
        
    });
    
});




</script>








