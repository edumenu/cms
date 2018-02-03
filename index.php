<?php include "includes/db.php";?>
<?php include "includes/header.php";?>
        <!-- Navigation  -->   
<?php include "includes/navigation.php";?>
   
   
    <!-- Page Content -->
    <div class="container">

      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h2 class="modal-title" style="text-align: center"><b>Content Management System (CMS)</b></h2>
            </div>
            <div class="modal-body">
              <h4><b>Description:</b></h4>
              <p>This is a full functional cms system which displays posts created by an admin user. 
              This system gives subscribers the chance to view individual posts based on categories and leave 
                  comments on each post.</p> 
                  <p>The admin, once logged in, will have the opportunity to have an overview of the 
              number of posts, comments, users and categories in the database associated with this cms. 
              The admin will also be able edit posts, categories, comments, users and even their own profile. </p><br>
              
              <h4><b>Languages and frameworks used:</b></h4><br>
              <img src="images/php.png" alt="bootstrap" width="20%" height="20%">
              <img src="images/bootstrap.png" alt="bootstrap" width="20%" height="20%">
              <img src="images/javascript.png" alt="bootstrap" width="10%" height="10%">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
<!--    </div>   -->

        <div class="row">

            <!-- Blog Entries Column -->
            
            
            <div class="col-md-8">
                
                <?php
                
                
                //Checking for a GET request called page and assigning it to a variable
                if(isset($_GET['page'])){
                    
                    

                $page = mysqli_real_escape_string($connection, $_GET['page']);

                }else{
                    
                $page = "";
                    
                }
                
                if($page == "" || $page == 1){
                    
                    $page_1 = 0;
                    
                    
                }else{
                    //If page is greater than 1 multiple ny 5 and substract by 5
                    $page_1 = ($page * 5 ) - 5;
                    
                }
                
            
                
                $select_query_count = "SELECT * FROM posts WHERE post_status = 'published'"; 
                $find_count = mysqli_query($connection,$select_query_count);
                //Counting the number of rows int he table
                $count = mysqli_num_rows($find_count);
                
                if($count < 1){
                   echo "<h1 class='text-center'>No Post available</h1>";
                }else{
                    
                $count = ceil($count / 5);
                
                //Display the number of posts based on the value of $page_1
                $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1,5";
                 $select_all_posts_query = mysqli_query($connection,$query);
                  
                //Print out data obtained from posts database
                //this function fecthes a row from the database as 
                //associative array
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'],50);
                    $post_status = $row['post_status'];
                ?>
                   
                   <h1 class="page-header">
                   Posts
                </h1>

                <!-- First Blog Post -->
                <h2>
                   <!-- The title of the post -->
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title?></a>
                </h2>
                <p class="lead">by 
                <!-- The author of the post -->
                <a href="author_post.php?p_author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p> <!-- The date of the post -->
                <hr>
                <a href="post.php?p_id=<?php echo $post_id?>">
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <!-- The content of the post -->
                <p><?php echo $post_content?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                
                

                <hr>
                   
            <?php  }  }?>


            </div>
            
            
        <!-- Blog sidebar widgets columns -->
            <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->
        
        <hr>
        
        <ul class="pager">
            
        <?php
       //Pagination    
    
        for($i = 1; $i <= $count; $i++){
            
         //Adding 
         if($i == $page){
             
             echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
             
         }else if($page == ""){
             $page = 1;
             echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
             
         }else{
          
             echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
             
         }
        
        }    
            
            
        ?>    
            
            
        </ul>

        <hr>
<?php include "includes/footer.php"; ?>
