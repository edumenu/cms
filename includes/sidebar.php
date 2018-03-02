<!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                
    <div class="well" data-spy="affix" data-offset-top="205">
        <h4>View project on github: <a class="btn btn-primary" href="https://github.com/edumenu/cms" target="_blank">Github</a></h4>
   </div> 
                
        <!-- Blog Search Well -->
        <div class="well">
            <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>
            </div>
            </form> <!-- Search from -->
            <!-- /.input-group -->
        </div>
                
                
       <!-- Login -->
    <div class="well" data-spy="affix" data-offset-top="205">
       <?php if(isLoggedIn()): ?>
       
       <h4>Logged in as: <b><?php echo $_SESSION['firstname']; echo " " . $_SESSION['lastname']?></b></h4>
       
       <h4>Go to admin page: <a href="admin/index.php" class="btn btn-primary">Admin Page</a></h4>
        
        <h4>Logout of profile: <a href="includes/logout.php" class="btn btn-danger">Logout</a></h4>
        
           <!--Checking for a post id-->
        <!-- Checking the user role, if the user is an admin or a subscriber, add an edit post link to the side navigation -->
        <?php if(isset($_GET['p_id'])){
                $the_post_id = $_GET['p_id'];
         ?>
        <h4>Edit post: <a class="btn btn-info" href='admin/posts.php?source=edit_post&p_id=<?php echo $the_post_id?>'>Edit Post</a></h4>
        <?php } ?>

       <?php else: ?>
       
       <h4>Login: <a href="login.php" class="btn btn-success">Login</a> </h4>
       
       <?php endif; ?>
       
    </div>
      
               
     <!--  Carousel for Admin pages  -->
<div class="well">
<div class="container1">
  <h3 style="text-align: center">Admin pages</h3>  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
      <li data-target="#myCarousel" data-slide-to="4"></li> 
      <li data-target="#myCarousel" data-slide-to="5"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="images/dashboard.jpg" alt="Dashboard" style="width:100%;">
         <div class="carousel-caption">
          <h3>Dashboard</h3>
        </div>
      </div>

      <div class="item">
        <img src="images/categories.jpg" alt="Categories" style="width:100%;">
        <div class="carousel-caption">
          <h3>Categories</h3>
        </div>
      </div>
    
      <div class="item">
        <img src="images/comments.jpg" alt="Comments" style="width:100%;">
        <div class="carousel-caption">
          <h3>Comments</h3>
        </div>
      </div>
       
       <div class="item">
        <img src="images/posts.jpg" alt="Posts" style="width:100%;">
        <div class="carousel-caption">
          <h3>Posts</h3>
        </div>
      </div>
      
       <div class="item">
        <img src="images/users.jpg" alt="Users" style="width:100%;">
        <div class="carousel-caption">
          <h3>Users</h3>
        </div>
      </div>
       
       <div class="item">
        <img src="images/profile.jpg" alt="Profile" style="width:100%;">
        <div class="carousel-caption">
          <h3>Profile</h3>
        </div>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
</div>        
                     
    <!-- Blog Categories Well -->
    <div class="well">

       <?php

    //Selecting data from the categories table in the cms database
    $query = "SELECT * FROM categories";
    $select_categories_sidebar = mysqli_query($connection,$query);

        ?>

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                   <?php

                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<li> <a href='category.php?category=$cat_id&title=$cat_title'>{$cat_title}</a> </li>";

                    }

                    ?>

                </ul>
            </div>


        </div>
        <!-- /.row -->
    </div>
          

                <!-- Side Widget Well -->
               <?php include "widget.php"; ?>

</div>