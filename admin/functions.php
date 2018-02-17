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
            
            
            $stmt = mysqli_prepare($connection,"INSERT INTO categories(cat_title) VALUES(?)");
            mysqli_stmt_bind_param($stmt, 's', $cat_title);
                                   
            mysqli_stmt_execute($stmt);
            
            confirmQuery($stmt);
            
            mysqli_stmt_close($stmt);

        }                       
    }    
}
?>


<?php
//Function to display all categories in the table 
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



//This function deletes categories from the table 
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

//This function dynamically records the number of records from a table
function recordCount($table){
    
    global $connection;
    //Displaying the number of users in the table    
    $query = "SELECT * FROM " . $table;    
    $select_all_post = mysqli_query($connection, $query);
    
    $result = mysqli_num_rows($select_all_post);
    
    confirmQuery($result);

    return $result;
}

function checkStatus($table,$column, $status){
    
        global $connection;
       //Retrieving posts that have a published status
        $query = "SELECT * FROM $table WHERE $column = '$status'";    
        $result = mysqli_query($connection, $query);
       return mysqli_num_rows($result);
    
}

//This function check the user's role
function checkUserRole($table,$column,$role){
    
        global $connection;
       //Retrieving posts that have a published status
        $query = "SELECT * FROM $table WHERE $column = '$role'";    
        $result = mysqli_query($connection, $query);
       return mysqli_num_rows($result);
    
}

//A function to check for duplicate username when registring
function username_exists($username){
    
    global $connection;
    
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    confirmQuery($result);
    
    if(mysqli_num_rows($result) > 0){
        
        return true;
    }else{
        return false;
    }
    
    
}

//A function to check for duplicate emails when registring 
function email_exists($email){
    
    global $connection;
    
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    
     confirmQuery($result);

    
    if(mysqli_num_rows($result) > 0){
        
        return true;
    }else{
        return false;
    }
    
}

//A function to redirect user to a different page
function redirect($location){
    
    return header("Location:" . $location);
    exit;
}

//Funtion to check for a request method
function ifItIsMethod($method=null){
    
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

//Function to check if user is logged in
function isLoggedIn(){
    
    if(isset($_SESSION['user_role'])){
        
        return true;
    }
    
    return false;
    
}

//If user is logged in, redirect them
function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}

//A registration function
function register_user($username,$email,$password){
    
         global $connection;

         $username = trim($_POST['username']);
         $password = trim($_POST['password']);
         $email    = trim($_POST['email']);

         //Encrypting information obtained from the user.
        //This function escapes special characters in a string for use in an SQL statement
         $username = mysqli_real_escape_string($connection, $username);
         $password = mysqli_real_escape_string($connection, $password);
         $email    = mysqli_real_escape_string($connection, $email);

        //first parameter = password
        //Second parameter = algorithm
        //cost is the amount of time it takes a function to give you a new hash 
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
        $query .= "VALUES('{$username}','{$email}','{$password}','subscriber')";
        $register_user_query = mysqli_query($connection, $query);
        
        //Checking if the query failed
        confirmQuery($register_user_query);

        // $message = " <div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        //     Your registration has been submitted!</div>";  
}

//A login function
function login_user($username, $password){
    
    global $connection;
    
    $username = trim($username);
    $password = trim($password);

    //Escaping special characters in a string
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password); 

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection,$query);

    if(!$select_user_query){

        die("Query failed!" . mysqli_error($connection));
    }


    while($row = mysqli_fetch_array($select_user_query)){

        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        
       if(password_verify($password,$db_user_password)) {

        //Setting a session
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

    //Open the admin the page when username and password are correct 
    redirect("/new_website/cms_2/admin");

    }else{
        return false;
    }    

    }
    
 return true;
}


function is_admin($username = ''){
    
     global $connection;

     $query = "SELECT user_role FROM users WHERE username = '$username'";

     $result = mysqli_query($connection,$query);

     confirmQuery($result);


     $row = mysqli_fetch_array($result);    

     if($row['user_role'] == 'admin'){

         return true;
     }else{

         return false;
     }
    
}



?>