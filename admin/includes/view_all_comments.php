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
    $query = "SELECT * FROM comments";
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
        echo "<td>$comment_email</td>";
        echo "<td>$comment_status</td>";
        
        $stmt = mysqli_prepare($connection, "SELECT post_id, post_title FROM posts WHERE post_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $comment_post_id);
        mysqli_stmt_execute($stmt);
        confirmQuery($stmt);
        mysqli_stmt_bind_result($stmt, $post_id, $post_title);
        
        
        while(mysqli_stmt_fetch($stmt)){
        
        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        
        }
        
        mysqli_stmt_close($stmt);
        
        
        echo "<td>$comment_date</td>";
        echo "<td><a href='comments.php?approved=$comment_id'>Approved</<a></td>";
        echo "<td><a href='comments.php?unapproved=$comment_id'>Unapproved</<a></td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" href='comments.php?delete=$comment_id'>Delete</<a></td>";
        echo "</tr>";
    }

    ?>

        </tbody>
</table>

<?php


//
if(isset($_GET['unapproved'])){
    
     //Making sure only admin users can delete users
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){
    //Obtaining the the comment id 
    $the_comment_id = escape($_GET['unapproved']);
            
    $stmt = mysqli_prepare($connection, "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $the_comment_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);        
            
    header("Location: comments.php"); //This will refresh the page
        }
    }
    
}


//
if(isset($_GET['approved'])){
    
     //Making sure only admin users can delete users
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){
     //Obtaining the the comment id 
    $the_comment_id = escape($_GET['approved']);
            
    $stmt = mysqli_prepare($connection, "UPDATE comments SET comment_status = 'approved' WHERE comment_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $the_comment_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);        
            
    header("Location: comments.php"); //This will refresh the page
        }
    }
    
}


//Delete link by each comment
if(isset($_GET['delete'])){
    
     //Making sure only admin users can delete users
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){
    
    $the_comment_id = escape($_GET['delete']);
       
    $stmt = mysqli_prepare($connection, "DELETE FROM comments WHERE comment_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $the_comment_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);         
            
    header("Location: comments.php"); //This will refresh the page
        }
    }
}


?>











