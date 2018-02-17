<table class = "table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
    <?php

   //Find all categories query
    $query = "SELECT * FROM users";
    $select_users = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_users)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        
        echo "<tr>";
        echo "<td>$user_id</td>";
        echo "<td>$username</td>";
        echo "<td>$user_firstname</td>";
        echo "<td>$user_lastname</td>";
        echo "<td>$user_email</td>";
        echo "<td>$user_role</td>";
        echo "<td><a class='btn btn-success' href='users.php?change_to_admin=$user_id'>Admin</<a></td>";
        echo "<td><a class='btn btn-success' href='users.php?change_to_sub=$user_id'>Subscriber</<a></td>";
        echo "<td><a class='btn btn-primary' href='users.php?source=edit_user&edit_user=$user_id'>Edit</<a></td>";
        echo "<td><a id='$user_firstname' rel='$user_id,$user_firstname' href='javascript:void(0)' class='btn btn-danger delete_link'>Delete</a></td>"; //it the result is undefined, the browser stays on the same page
        
//        echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" href='users.php?delete=$user_id'>Delete</<a></td>";
        echo "</tr>";
    }

    ?>

        </tbody>
</table>

<?php


//Change user role to admin
if(isset($_GET['change_to_admin'])){
    
    //Making sure only admin users can delete users
    if(isset($_SESSION['user_role'])){
        
      if($_SESSION['user_role'] == 'admin'){
    
    $the_user_id = escape($_GET['change_to_admin']);
//    
//    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id ";
//    $change_admin_query = mysqli_query($connection,$query);
          
    $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = 'admin' WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $the_user_id);
    mysqli_stmt_execute($stmt);
    //Checking for errors
    confirmQuery($stmt);
    
    header("Location: users.php"); //This will refresh the page
            
      }
        
    }
    
}


//Change user role to subscriber
if(isset($_GET['change_to_sub'])){
    
    //Making sure only admin users can delete users
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){
    
    $the_user_id = escape($_GET['change_to_sub']);
    
     $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = 'subscriber' WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $the_user_id);
    mysqli_stmt_execute($stmt);
            
    header("Location: users.php"); //This will refresh the page
            
        }
        
    }
    
}


//Delete link by each comment
if(isset($_POST['delete'])){
    
    //Making sure only admin users can delete users
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){

          $the_user_id =  escape($_POST['user_id']);

        $stmt = mysqli_prepare($connection, "DELETE FROM users WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $the_user_id);
        mysqli_stmt_execute($stmt);
        //Checking for errors
        confirmQuery($stmt);         
            
    header("Location: users.php"); //This will refresh the page
            
        }
        
    }
    
}


?>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-sm">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm deletion</h4>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Are you sure you want to delete <b><span id="name" value=""></span></b>?</h3>
      </div>
      <div class="modal-footer">        
          
     <form method="post">
         
             <button type="button" class="btn btn-default pull right" data-dismiss="modal">Cancel</button>  
            
            <input id="modal_delete_link" type="hidden" name="user_id" value="" >
            
            <button type='submit' name='delete' value='Delete' class='btn btn-danger'>Delete</button>
         
     </form> 
          
      </div>
    </div>
    </div>
  </div>
</div>


<script>

//Adding a modal to to the delete link
$(document).ready(function(){
    
    $(".delete_link").on('click', function(){

        var id = $(this).attr("rel");  //Obtaining the post id from rel attribute
        var name = $(this).attr("id");
        
        $("#myModal").modal('show');  //Display the modal
        
        //Displaying the user's name to be deleted
        document.getElementById('name').innerHTML = name;
        document.getElementById('modal_delete_link').setAttribute("value",id);  //Set post id to the attribute value 
        
        
    });
    
});

</script>










