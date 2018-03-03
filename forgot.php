<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
//Load composer's autoloader
require './vendor/autoload.php';
//Add the config class
require './classes/Config.php';

    if(!isset($_GET['forgot'])){

        redirect('index');

    }

    if(ifItIsMethod('post')){
        //Obtaining the email from the form 
        if(isset($_POST['email'])) {

            $email = $_POST['email'];

            $length = 50;
            //This function converts a string of ASCII to hexadecimal 
            $token = bin2hex(openssl_random_pseudo_bytes($length));


            if(email_exists($email)){

                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email= ?")){

                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    /**
                     * configure PHPMailer
                     */

                    $mail = new PHPMailer();

                    $mail->isSMTP();            //Set mailer to use SMTP
                    $mail->Host = Config::SMTP_HOST;    //Specify main and backup SMTP servers       
                    $mail->Username = Config::SMTP_USER;    //SMTP username
                    $mail->Password = Config::SMTP_PASSWORD; //SMTP password
                    $mail->Port = Config::SMTP_PORT;
                    $mail->SMTPSecure = 'tls';       //Enable TLS encryption, ssl also accepted
                    $mail->SMTPAuth = true;    // Enable SMTP authentication
                    $mail->isHTML(true);       // Set email format to HTML
                    $mail->CharSet = 'UTF-8';


                    $mail->setFrom('edumenu@liberty.edu', 'Edem Dumenu');
                    $mail->addAddress($email);

                    $mail->Subject = 'This is a test email';

                    $mail->Body = '<p>Please click to reset your password

                    <a href="http://localhost/new_website/cms_2/reset.php?email='.$email.'&token='.$token.' ">http://localhost/new_website/cms_2/reset.php?email='.$email.'&token='.$token.'</a>

                    </p>';


                    if($mail->send()){

                        $emailSent = true;

                    } else{

                        echo "NOT SENT";

                    }

                }

            }

        }


     }
?>


<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                        <?php if(!isset( $emailSent)): ?>


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">



                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            <?php else: ?>


                                <div class="alert alert-success"><strong>Please check your email!</strong></div>


                            <?php endIf; ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

