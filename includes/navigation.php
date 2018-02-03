<?php if (session_status() == PHP_SESSION_NONE){ session_start(); }?>
   
   
   <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
           
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Front</a>
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <?php 
                
                //Selecting data from the categories table in the cms database
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection,$query);
                  
                //Print out data obtained from database
                //this function fecthes a row from the database as 
                //associative array
                while($row = mysqli_fetch_assoc($select_all_categories_query)){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    
                    echo "<li> <a href='category.php?category=$cat_id&title=$cat_title'>{$cat_title}</a> </li>";
                    
                }
                    
                    
                ?>
                   
                <li>
                    <a href="admin">Admin</a>
                </li>

                <?php
               //Checking the user role, if the user is an admin or a subscriber, add an edit post link to the navigation 
                if(isset($_SESSION['user_role'])){
                //Checking for a post id 
                    if(isset($_GET['p_id'])){
                        
                        $the_post_id = $_GET['p_id'];
                        
                        echo "<li><a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                        
                    }
                    
                    
                }

                ?>


                <li>
                    <a href="registration.php">Registration</a>
                </li>
                   <li>
                    <a href="contact.php">Contact</a>
                </li>
                    
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>