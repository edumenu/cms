<?php include "includes/admin_header.php"; ?>
    

<div id="wrapper">
        
       
       <?php include "includes/admin_navigation.php"?>
        
    <div id="page-wrapper">

     <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">

               <h1 class="page-header">
                    Welcome to Coments
                    <small>Author</small>
                </h1>




<table class = "table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In response to</th>
                <th>Date</th>
                <th>Approved</th>
                <th>Unapproved</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
    <?php

   //Find all categories query
    $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']) . "" ;
    $select_comments = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_comments)){
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];
        
        echo "<tr>";
        echo "<td>$comment_id</td>";
        echo "<td>$comment_author</td>";
        echo "<td>$comment_content</td>";
        
        
        
//        $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
//        $select_categories_id = mysqli_query( $connection, $query);
//
//        while($row = mysqli_fetch_assoc($select_categories_id)){
//        $cat_id = $row['cat_id'];
//        $cat_title = $row['cat_title'];
//        
//        
//        
//        echo "<td>{$cat_title}</td>";
//            
//        }
        
        echo "<td>$comment_email</td>";
        echo "<td>$comment_status</td>";
        
        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
        $select_post_id_query = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_post_id_query)){
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
        
        
        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        
        }
        
        
        echo "<td>$comment_date</td>";
        echo "<td><a href='post_comments.php?approved=$comment_id&id=" . $_GET['id'] . "'>Approved</<a></td>";
        echo "<td><a href='post_comments.php?unapproved=$comment_id&id=" . $_GET['id'] . "'>Unapproved</<a></td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . "'>Delete</<a></td>";
        echo "</tr>";
    }

    ?>

        </tbody>
</table>

<?php


//
if(isset($_GET['unapproved'])){
    
       //Making sure only admin users can delete posts
    if(isset($_SESSION['user_role'])){
        
        if(isset($_SESSION['user'])){
    
    $the_comment_id = escape($_GET['unapproved']);
    
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
    $unapprove_query = mysqli_query($connection,$query);
    if(!$unapprove_query){
      die("Query Failed!" . mysqli_error($connection));
    }
    header("Location: post_comments.php?id=" . $_GET['id'] .""); //This will refresh the page
            
        }
        
    }
    
}


//
if(isset($_GET['approved'])){
    
       //Making sure only admin users can delete posts
    if(isset($_SESSION['user_role'])){
        
        if(isset($_SESSION['user'])){
    
    $the_comment_id = escape($_GET['approved']);
    
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id ";
    $approve_query = mysqli_query($connection,$query);
    if(!$approve_query){
      die("Query Failed!" . mysqli_error($connection));
    }
    header("Location: post_comments.php?id=" . $_GET['id'] .""); //This will refresh the page
        }
    }
    
}


//Delete link by each comment
if(isset($_GET['delete'])){
    
       //Making sure only admin users can delete posts
    if(isset($_SESSION['user_role'])){
        
        if(isset($_SESSION['user'])){
    
    $the_comment_id = escape($_GET['delete']);
    
    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
    $delete_query = mysqli_query($connection,$query);
    header("Location: post_comments.php?id=" . $_GET['id'] .""); //This will refresh the page
            
        }
        
    }
    
}


?>


   </div>
        </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
            
         <!-- /#page-wrapper -->
            
         <?php include "includes/admin_footer.php"; ?>










