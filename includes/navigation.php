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
                <a class="navbar-brand" href="/new_website/cms_2/index">CMS Front</a>
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
                    
                    $category_class = '';
                    
                    $registration_class = '';
                    
                    $contact_class = '';
                    
                    //This will tell us the current page we are on
                    $pageName = basename($_SERVER['PHP_SELF']);
                    
                    $registration = 'registration.php';
                    
                    $contact = 'contact.php';
                    
                    //Assigning a active  
                    if(isset($_GET['category']) && $_GET['category'] == $cat_id){
                        
                       $category_class = 'active'; 
                        
                    }else if($pageName == $registration){
                        
                        $registration_class = 'active';
                    }else if($pageName == $contact){
                        
                        $contact_class = 'active';
                    }
                    
                    echo "<li class='$category_class'> <a href='category.php?category=$cat_id&title=$cat_title'>{$cat_title}</a> </li>";
                    
                }
                    
                ?>

                <li class='<?php echo $$registration_class; ?>'>
                    <a href="/new_website/cms_2/registration">Registration</a>
                </li>
                   <li  class='<?php echo $contact_class; ?>'>
                    <a href="/new_website/cms_2/contact">Contact</a>
                </li>
                    
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>