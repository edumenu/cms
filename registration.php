<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 

require 'vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$options = array(
    'cluster' => 'us2',
    'encrypted' => true
  );

//Importing the pusher package
//Using the getenv to retreive variables
$pusher = new Pusher\Pusher(getenv('APP_KEY'),getenv('APP_SECRET'),getenv('APP_ID'),$options);

?>
 
 <?php

//Detecting a post method
if($_SERVER['REQUEST_METHOD'] == "POST"){
 

     $username = $_POST['username'];
     $password = $_POST['password'];
     $email = $_POST['email'];

    //Associative error array
     $error = [

       'username'=> '',
       'email'=> '',
       'password'=> ''
     ];

     //Checking for the length of the username    
     if(strlen($username) < 4){
         $error['username'] = 'Username needs to longer';
     }

     //Checking to see if username is empty     
     if($username == ''){
         $error['username'] = 'Username cannot be empty';
     }

    //Checking to see if username exists    
     if(username_exists($username)){
         $error['username'] = 'Username already exists';
     }

     //Checking to see if email is empty     
     if($email == ''){
         $error['email'] = 'Email cannot be empty';
     }

    //Checking to see if email is exist    
     if(email_exists($email)){
         $error['email'] = 'Email already exists"';
     }

     //Checking to see if password is empty     
     if($password == ''){
         $error['password'] = 'Password cannot be empty';
     }

    //Looping thorugh the array of errors 
     foreach($error as $key=> $value){

         if(empty($value)){

             //Destroying any variables in the array
             unset($error[$key]);

         }

     }//End of foreach


    if(empty($error)){

        //Registring the new user
        register_user($username, $email, $password);

        //Loging in the user after registration
//          login_user($username, $password);
        $data['message'] = $username;
        $pusher->trigger('notifications', 'new_user', $data);
        

    }
    
}
?>

    <!-- Navigation -->   
    <?php  include "includes/navigation.php"; ?>
    
 
<!-- Page Content -->
<div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="text-center">Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
        
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on"
                                   
                            value="<?php echo isset($username) ? $username : ''?>">
                            
                            <p><?php echo isset($error['username']) ? $error['username'] : ''?></p>
                            
                        </div>
                        
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on"
                                   
                            value="<?php echo isset($email) ? $email : ''?>">
                             
                            <p><?php echo isset($error['email']) ? $error['email'] : ''?></p>
                             
                        </div>
                        
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                             
                             
                               <p><?php echo isset($error['password']) ? $error['password'] : ''?></p>
                             
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>



<?php include "includes/footer.php";?>
