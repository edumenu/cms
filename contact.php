<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
 
 <?php

if(isset($_POST['submit'])){
 
 $to = "ehdemdume@gmail.com";    //Sender's email
 $subject = wordwrap($_POST['subject'], 70); //Wordrap wraps a string into another line when it reaches a specific length
 $body = $_POST['body'];  //Body of the email
 $header =  $_POST['email'];
    
    
 // send email
mail($to,$subject,$body,$header);
    
    echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
     Email sent! </div>";
    
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
                <h1 class="text-center">Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                           <div class="form-group">
                            <label for="text" class="sr-only">Subject</label>
                            <input type="subject" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                        </div>
                         <div class="form-group">
                           
                            <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                  
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>

                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


<hr>

<?php include "includes/footer.php";?>
