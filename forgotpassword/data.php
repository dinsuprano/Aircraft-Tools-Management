<?php 
include_once "../tools/connectdb.php";
require_once "data.php";
$useremail = "";
session_start();
$errors = array();


$useremail= $_SESSION['useremail'];

// send otp to change password
if(isset($_POST['check-email'])){
try{
    
        $useremail = $_POST['txte'];
        $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");

        $select->execute();

        if($select->rowCount()>0){

            $code = rand(999999, 111111);
            $query="UPDATE tbl_user SET code = $code WHERE useremail ='$useremail'";
            $statement = $pdo->prepare($query);

            
            if($statement->execute()){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From Tools Management Online Team";
                if(mail($useremail, $subject, $message, $sender)){
                    $info = "We've sent a passwrod reset otp to your email - $useremail";
                    $_SESSION['info'] = $info;
                    $_SESSION['useremail'] = $useremail;
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{

                $errors['email'] = "This email address does not exist!";
            }

        }
        else{

            $errors['email'] = "This email address does not exist!";

        }
        
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

}

//Check OTP
if(isset($_POST['check-reset-otp'])){
    try{
        $code = $_POST['otp'];
        $select=$pdo->prepare("select code from tbl_user where code='$code'");
        $select->execute();
        if($select->rowCount()>0){
     
            $_SESSION['useremail'] = $useremail;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
        }
        else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }
        
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}

//change password
if(isset($_POST['change-password'])){
    try{

        $_SESSION['info'] = "";
        $newpassword_txt=$_POST['txt_newpassword'];
        $rnewpassword_txt=$_POST['txt_rnewpassword'];
        
        $select =$pdo->prepare("select * from tbl_user where useremail='$useremail'");
        $select->execute();
        $row=$select->fetch(PDO:: FETCH_ASSOC);
    
        if($newpassword_txt==$rnewpassword_txt){
    
        $enc_password= password_hash($newpassword_txt,PASSWORD_DEFAULT);
        $code=0;
        $update=$pdo->prepare("update tbl_user set userpassword=:pass , code=:code where useremail=:email");
        $update->bindParam(':code',$code);
        $update->bindParam(':pass',$enc_password);
        $update->bindParam(':email',$useremail);


        if($update->execute()){
    
            $info = "Your password changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
    
        }else{
    
            $errors['db-error'] = "Failed to change your password!";
    
        }

        }else{
            $errors['db-error'] = "Failed to change your password!";
    
        }
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}

?>