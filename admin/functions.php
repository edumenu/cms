<?php

//This function escapes special characters in a string in order to be used in SQL statement 
function escape($string){
    
    global $connection;
    
return mysqli_real_escape_string($connection, trim($string));
    
}


function logOut(){
    
session_start();
//This function creates a new session or resumes a current one based on a session identifier passed via GET or POST 

//Ending a users session
$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['user_role'] = null;

header("Location: ../index.php");


}



function users_online(){
    
    if(isset($_GET['onlineusers'])){

    global $connection;
        
    //If no connection, include the db.php
    if(!$connection){
        
        session_start();
        
        include("../includes/db.php");
        
        //Setting a session for the user       
        $session = escape(session_id());
        $time = escape(time());      //Calculating if the user has been on the website for more or less than 30 seconds 
        $time_out_in_seconds = 5; 
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);    //Counting to see users online

        if($count == NULL){
        //Insert a new user when the users_online table is empty
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session','$time')");

        }else{
        //Updating if the user is not new
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");

        }

        //Selecting users that are online longer than the time_out
        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        echo $count_user = mysqli_num_rows($users_online_query);
        
        
           }    


       }  // get request isset()
        
        
}

users_online();



//Funciton to check query confirmation
function confirmQuery($result){
    
    global $connection;
    
    if(!$result){
        
         die("Query Failed!" . mysqli_error($connection));
         
     }
    
}

//Function to insert categories into the table
function insert_categories(){
    
    global $connection;
    
    if(isset($_POST['submit'])){
                         
          $cat_title = escape($_POST['cat_title']);


        if($cat_title == "" || empty($cat_title)){
           echo "This field should not be empty!";
        }else{
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUE('{$cat_title}')";

            $create_category = mysqli_query($connection,$query);

            if(!$create_category){

                die('QUERY FAILED'. mysqli_error($connection));

            }

        }                       
    }    
}
?>


<?php
//Fucnction to display all categories in the table 
function findAllCategories(){
    
    global $connection;
    
    //Find all categories query
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" href = 'categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href = 'categories.php?edit={$cat_id}'>Edit</a></td>"; 
        echo "<tr>";
    }
    
}




function delete_categories(){
    
     global $connection;
    
    //Delete query
     //Checking for a get request       
    if(isset($_GET['delete'])){
     $the_cat_id = escape($_GET['delete']);

     $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";

    $delete_query = mysqli_query($connection, $query);
    header("Location: categories.php"); //This will refresh the page


    }  
 
}



?>