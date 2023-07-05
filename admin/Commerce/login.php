
<?php 
session_start();
$pagetitle = 'login';
if(isset($_SESSION['user'])){
    header('Location: index.php');
}
include 'init.php';
//  include $lang . 'english.php';
include $tpl . 'footer.php';
 

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
     if(isset($_POST['login'])){
                $user = $_POST['username'];
                $pass = $_POST['password'];
                
            //   echo $user . $pass ;

                $hashedPass = sha1($pass);
                
                $stmt = $con->prepare("SELECT  
                                                username, password 
                                        FROM    users 
                                        WHERE   username = ? 
                                        AND      password = ? ");

                $stmt->execute(array($user, $hashedPass));
            //      $row=$stmt->fetch();
                $count = $stmt->rowCount(); 
            //     //  echo $hashedPass;
                if($count > 0){ 
                    
                    $_SESSION['user'] = $user;
                    //   print_r($_SESSION);
            //          $_SESSION['id']=$row['userid'];
            //         // echo'lijk' . $username;
                    header('location: index.php');
                    exit();
     } }else{

                $formerror = array();
                $username = $_POST['username'];
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                $email = $_POST['email'];

                if(isset($username)){
                    $filterduser = filter_var($username, FILTER_SANITIZE_STRING);
                    if(strlen($filterduser) < 4){
                    $formerror[] ='username must be larger than 4 characters';  
                    }
        
                }
                if(isset($password) && isset($password2)){
                    if(empty($password)) {

                    $fromerror[] = 'sorry password cant be empty';

                    }
                $pass = sha1($password) ;
                $pass2 = sha1($password2);

                if($pass !== $pass2){

                    $formerror[] = 'sorry password is not match';
                
                    }

                }
                if(isset($email)){
                    $filterdemail = filter_var($email, FILTER_SANITIZE_EMAIL);

                    if(filter_var($filterdemail, FILTER_VALIDATE_EMAIL) != true){
                    $formerror[] ='this email is not valid';  
                    }
        
                }
                
                if(empty($formerror)){

                    $check = checkitem("username", "users", $username);
                    
                    if($check == 1){
                        $formerror[] ='sorry this user is exists';
                        // $theMsg ="<div class='alert alert-danger'>Sorry this user is Exist</div>";

                    }else{

                    $stmt = $con->prepare("INSERT INTO users(username, password, email, regstatus,Date)
                                                    VALUES(:zuser, :zpass, :zemail, 0,now())");
                    $stmt->execute(array(
                        'zuser'  =>  $username ,
                        'zpass'  =>  sha1($password) ,
                        'zemail' =>  $email 
                        
                    ));
                    // echo'username cant be empty';
                    $succesmsg = 'Congrats You Are Now Registerd User';                
            //         // echo $id . $user . $email . $name 
            //     // $stmt->execute(array($userid));
                // $theMsg ="<div class='alert alert-success'>" .$stmt->rowCount().' Record INSERT ' ."</div>";
            //     redirectHome($theMsg, 'back');
            // }    
         }
            }

     }
 }?>

<div class="container login-page">
<h1 class="text-center">
<span class="selected" data-class="login" >login </span> |
<span  data-class="signup">signup</span>
</h1>
<!-- start login form -->
<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<div class="input-container">
        <input class="form-control" type="text" name="username" autocomplete="off"
        placeholder="type your username "  />
        <span class="asterisk">*</span>
</div>
<div class="input-container">
        <input class="form-control" type="password" name="password" 
        autocomplete="new-password" 
        placeholder="type your password" />
</div>
    <input class="btn btn-primary btn-block" name="login" type="submit" value="login" />
</form>
<!-- End login form -->
<!-- start signup form -->
<form class="signup"  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<div class="input-container">
<input pattern=".{4,8}" 
title="username must be bettween 4 & 8 chars"
 class="form-control" type="text" name="username" autocomplete="off"
placeholder="type your username " required/>
</div>
<div class="input-container">
<input minlength="4" class="form-control" type="password"
 name="password" autocomplete="new-password"
placeholder="type a complex password again" required />
</div>
<div class="input-container">
<input class="form-control" type="password" name="password2" 
autocomplete="new-password"
placeholder="type a complex password" />
</div>
<div class="input-container">
<input class="form-control" type="email" name="email" 
placeholder="type a valid email" />
</div>
<input class="btn btn-success btn-block" name="signup" type="submit" value="signup" />
</form>
<!-- End signup form -->
<div class="the-errors text-center">
<?php 
if(!empty($formerror)) {
    foreach($formerror as $error){
        echo $error . '<br >';
    }
}
if(isset($succesmsg)){
    echo '<div calss="msg success">' .$succesmsg . '</div>';
}
?>
</div>
</div>

<?php include $tpl . 'footer.php'; 
 ?>