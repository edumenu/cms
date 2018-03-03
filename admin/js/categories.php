<?php include "includes/admin_header.php"; ?>
    
    <div id="wrapper"> 
       
       <?php include "includes/admin_navigation.php"?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                        
                        <div class="col-xs-6">
                        
                        <?php insert_categories();?>
                        
                        <form action="" method="post">
                        <div class="form-group">
                        <label for="cat_title">Add Category</label>
                        <input class="form-control" type="text" name = "cat_title">    
                            
                        </div>
                        
                        <div class="form-group">
                            
                        <input class = "btn btn-primary" type="submit" name = "submit" value = "Add Category">    
                            
                        </div>
                        </form> 
 
                        <form action="" method="post">

                        <div class="form-group">
                        <label for="cat_title">Edit Category </label>

                            <?php // Update and include query 

                                if(isset($_GET['edit'])){

                                $cat_id = escape($_GET['edit']);

                                include "includes/update_categories.php";

                                } 

                            ?> <!-- Calling the update_category file -->

                        </div>
                        <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
                        </div>

                        </form>
                        
                        </div> <!-- Add and Edit Category Form -->
                        
                        <div class="col-xs-6">
    
                        <table class = "table table-bordered table-hover">
                            <thread>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                </tr>
                            </thread>
                            <tbody>
                              

                       <?php findAllCategories(); ?>
                               
                        <?php   
                        //Delete query
                                
                                
                         //Checking for a get request       
                        if(isset($_GET['delete'])){
                            
                         $the_cat_id = escape($_GET['delete']);
                            
                        $stmt = mysqli_prepare($connection, "DELETE FROM categories WHERE cat_id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $the_cat_id);
                        mysqli_stmt_execute($stmt);
                            
                        header("Location: categories.php"); //This will refresh the page
                        }       
                        
                        ?>
                                         
                            </tbody>
                        </table>
                            
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
            
            
         <?php include "includes/admin_footer.php"; ?>
