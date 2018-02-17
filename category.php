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
                if(isset($_GET['category'])){
                    
                    $post_category_id = mysqli_real_escape_string($connection, $_GET['category']);
                    $post_category_title = mysqli_real_escape_string($connection, $_GET['title']);
                    
                if(is_admin($_SESSION['username'])){
                    
                //View all drafts and published posts
                 $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");
 
                }else{
                    
                    //View only published
                    $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");
                    
                    $published = 'published';
                }
                    
                if(isset($stmt1)){
                    
                    mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
                    
                    mysqli_stmt_execute($stmt1);
                    
                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    
                    $stmt = $stmt1;
                    mysqli_stmt_store_result($stmt);
                    
                }else{
                    
                    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published );
                    
                    mysqli_stmt_execute($stmt2);
                    
                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    
                     $stmt = $stmt2;
                    mysqli_stmt_store_result($stmt);
                }
                 
                    
                if(mysqli_stmt_num_rows($stmt) == 0){
                    
                    echo "<h1 class='text-center'>No Categories available</h1>";
                    
                }
                  
                //Print out data obtained from posts database
                //this function fecthes a row from the database as an 
                //associative array
                while(mysqli_stmt_fetch($stmt)):
                    
                ?>
                   
                   <h1 class="page-header">
                    <?php 
                        echo $post_category_title;   
                       ?>
<!--                    <small>Secondary Text</small>-->
                </h1>

                <!-- First Blog Post -->
                <h2>
                   <!-- The title of the post -->
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title?></a>
                </h2>
                <p class="lead">by 
                <!-- The author of the post -->
                <a href="index.php"><?php echo $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p> <!-- The date of the post -->
                <hr>
                <a href="post.php?p_id=<?php echo $post_id?>">
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <!-- The content of the post -->
                <p><?php echo $post_content?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                   
            <?php endwhile; mysqli_stmt_close($stmt); } else{
                    header("Location: index.php");
                }
                 ?>


            </div>
            
            
        <!-- Blog sidebar widgets columns -->
            <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>
<?php include "includes/footer.php"; ?>
