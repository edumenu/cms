<?php include "includes/db.php";?>
<?php include "includes/header.php";?>
   
        <!-- Navigation  -->   
<?php include "includes/navigation.php";?>
   
   
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            
            <div class="col-md-8">
                
                <?php
                
                //Retrieving the post's ID number using the get request
                if(isset($_GET['p_id'])){
                    
                    $the_post_id = $_GET['p_id'];
                
                //Obtaining the number of views on each post 
                $stmt = mysqli_prepare($connection, "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = ?");
                mysqli_stmt_bind_param($stmt, "i", $the_post_id);
                mysqli_stmt_execute($stmt);

                confirmQuery($stmt);
                                
                    
                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                 $stmt1 = mysqli_prepare($connection, "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_id = ?");
                 mysqli_stmt_bind_param($stmt1, "i", $the_post_id);
                    
                }else {
                    $stmt1 = mysqli_prepare($connection, "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_id = ? AND post_status = 'published' ");
                    mysqli_stmt_bind_param($stmt1, "i", $the_post_id);
                }
                    
                   mysqli_stmt_execute($stmt1);
                   mysqli_stmt_bind_result($stmt1, $post_title, $post_author, $post_date, $post_image, $post_content);
                   mysqli_stmt_store_result($stmt1);
                    
                if(mysqli_stmt_num_rows($stmt1) < 1){
                    
                 echo "<h1 class='text-center'>No posts available</h1>";
                }else{
                    
                  
                //Print out data obtained from posts database
                //this function fetches a row from the database as 
                //associative array
                while(mysqli_stmt_fetch($stmt1)){

                    
                ?>
                   
                   <h1 class="page-header">
                    Posts
                </h1>

                <!-- First Blog Post -->
                <h2>
                   <!-- The title of the post -->
                    <a href="#"><?php echo $post_title?></a>
                </h2>
                <p class="lead">by 
                <!-- The author of the post -->
                <a href="author_post.php?p_author=<?php echo $post_author; ?>&p_id=<?php echo $the_post_id; ?>"><?php echo $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p> <!-- The date of the post -->
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <!-- The content of the post -->
                <p><?php echo $post_content?></p>

                <hr>
                   
            <?php  } 
                
                
                ?>
            
             <!-- Blog Comments -->
             
                <?php
                //Creating comments for each post
                if(isset($_POST['create_comment'])){
                    
                    
                     $the_post_id = mysqli_real_escape_string($connection, $_GET['p_id']); 
                    
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                    
                    
                    
                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
                    
                    $commentStatus = "unapproved";    
                    $date = date('d-m-y');    
                        
                    $stmt1 = mysqli_prepare($connection, "INSERT INTO comments (comment_post_id,comment_author,comment_email,comment_content, comment_status, comment_date) VALUES (?,?,?,?,?,?)");
                    mysqli_stmt_bind_param($stmt1, "isssss", $the_post_id, $comment_author, $comment_email, $comment_content, $commentStatus, $date);
                    mysqli_stmt_execute($stmt1);
                        
                //This increments the number comments in the db
//                 $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
//                 $query .= "WHERE post_id = $the_post_id ";
//                 $update_comment_count = mysqli_query($connection,$query);
                    
                    
                }else{
                       
                    echo "<script> alert ('Fields cannot be empty!') </script>";
                        
                    }
                        
                        
                    }
                    
                ?>


                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        
                           <div class="form-group">
                           <label for="Author">Author:</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                          
                          <div class="form-group">
                           <label for="Email">Email:</label>
                            <input type="email" class="form-control" name="comment_email">
                        </div>
                           
                           <div class="form-group">
                           <label for="comment">Your Comment:</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                
                <?php
                //Creating a query to select all approved comments
                
//                $query = "SELECT * FROM comments WHERE comment_post_id ={$the_post_id} ";
//                $query .="AND comment_status = 'approved' ";
//                $query .="ORDER BY comment_id DESC";
//                $select_comment_query = mysqli_query($connection, $query);
//                if(!$select_comment_query){
//                    die("Query Failed!" . mysqli_error($connection));
//                
//                }
//                    
              
                $stmt2 = mysqli_prepare($connection, "SELECT comment_date, comment_content, comment_author FROM comments WHERE comment_post_id = ? AND comment_status = 'approved' ORDER BY comment_id DESC");
                mysqli_stmt_bind_param($stmt2, "i", $the_post_id);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_bind_result($stmt2, $comment_date, $comment_content, $comment_author);
                    
                    
                while(mysqli_stmt_fetch($stmt2)){
//                $comment_date = $row['comment_date'];
//                $comment_content = $row['comment_content'];
//                $comment_author = $row['comment_author'];
                    
                    ?>
                    
                     <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author;?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                       <?php echo $comment_content; ?>
                    </div>
                </div>
                 <?php } }  } else {
                    
                  header("Location: index.php");      
                    
                    
                } ?>

            </div>
            
            
        <!-- Blog sidebar widgets columns -->
            <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>
<?php include "includes/footer.php"; ?>
