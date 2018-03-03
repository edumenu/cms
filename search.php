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
                

            if(isset($_POST['submit'])){
                
            $search = mysqli_real_escape_string($connection, $_POST['search']);   
            
            $stmt = mysqli_prepare($connection, "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_tags LIKE ?");
            mysqli_stmt_bind_param($stmt,"s", $search);
            mysqli_stmt_execute($stmt);
            confirmQuery($stmt);
            mysqli_stmt_bind_result($stmt,$post_title, $post_author, $post_date, $post_image, $post_content);
            mysqli_stmt_store_result($stmt);
            $count = mysqli_stmt_num_rows($stmt);
                
                if($count == 0){
                    echo "<h1> No Result</h1>";
                }else{
    
                while(mysqli_stmt_fetch($stmt)){
                ?>
                   
                   <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                   <!-- The title of the post -->
                    <a href="#"><?php echo $post_title?></a>
                </h2>
                <p class="lead">by 
                <!-- The author of the post -->
                <a href="index.php"><?php echo $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p> <!-- The date of the post -->
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <!-- The content of the post -->
                <p><?php echo $post_content?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                   
            <?php  } 

                }
                
            }       
  ?>

            </div>
            
            
        <!-- Blog sidebar widgets columns -->
            <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>
<?php include "includes/footer.php"; ?>
