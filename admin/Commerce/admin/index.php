
<?php
session_start();
$noNavbar='';
$pagetitle='login';
if(isset($_SESSION['username'])){
    header('location: dashboard.php');
} 
include 'init.php';
//  include $lang . 'english.php';
include $tpl . 'header.php';
 

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $username = $_POST['user'];
     $password = $_POST['pass'];
      $hashedPass = sha1($password);
     
     $stmt = $con->prepare("SELECT userid, username, password 
                             FROM users
                              WHERE username = ?
                               AND password = ?
                                AND groupid=1
                                 LIMIT 1");
     $stmt->execute(array($username, $hashedPass));
     $row=$stmt->fetch();
     $count = $stmt->rowCount(); 
    //  echo $hashedPass;
     if($count > 0){ 
        //  print_r($row);
         $_SESSION['username']=$username;
         $_SESSION['id']=$row['userid'];
        // echo'lijk' . $username;
         header('location: dashboard.php');
         exit();
     }
 }
   ?>
   
  <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
         <h4 class="text-center">admin login</h4>
        <input class="form-control input-lg " type="text" name="user" autocomplete="off" placeholder="username"  />
        <input  class="form-control input-lg " type="password" name="pass" outocomplete="new-password" placeholder="password"  />
        <input  class="btn btn-lg btn-primary btn-block" type="submit" value="login" />
  </form>


<?php include $tpl . 'footer.php'; ?>