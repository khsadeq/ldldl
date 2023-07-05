
<?php 
 session_start();
 $pagetitle ='profile';
 include 'init.php';
 
//  echo $sessionuser ;
 if(isset($_SESSION['user'])){
 $getuser =$con->prepare("SELECT * FROM users WHERE username = ? ");
 $getuser->execute(array($sessionuser));
 $info = $getuser->fetch();

?>

<h1 class="text-center">My profile</h1>

<div class="information block">
    <div class="container">
         <div class="panel panel-primary">
              <div class="panel-heading">My information </div>
              <div class="panel-body">
              <ul class="list-unstyled">
              <li>
              <i class="fa fa-unlock-alt  fa-fw"> </i>
             <span> Name</span> : <?php echo $info['username'] ?>
              </li>
              <li>
              <i class="fa fa-envelope-o  fa-fw"> </i>
              <span>Email</span> : <?php echo $info['email'] ?>
              </li>
              <li>
              <i class="fa fa-user  fa-fw"> </i>
              <span>full Name</span> : <?php echo $info['fullname'] ?>
              </li>
              <li>
              <i class="fa fa-calendar  fa-fw"> </i>
              <span>Register Dala</span> : <?php echo $info['Date']  ?>
              </li>
              <li>
              <i class="fa fa-tags  fa-fw"> </i>
              <span>favourite Category</span> : <?php echo $info['userid'] ?>
              </li>
              </ul>
              </div>
            </div>
      </div>
 </div>

 <div class="my-ads block">
       <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Ads </div>
                <div class="panel-body">
                 <?php 
                 if(! empty(getitems('Member_ID', $info['userid']))){
                 echo'<div class="row">';
                 foreach (getitems('Member_ID', $info['userid']) as $item) {
                          echo  '<div class ="col-sm-6 col-md-3">';
                             echo '<div class ="thumbnail item-box">';
                                  echo '<span class ="price-tag">' . $item['Price'] . '</span>';
                                  echo '<img class="img-responsive" src=" [001348].png" alt="" />';
                                  echo '<div class="caption">';
                                        echo '<h3>' . $item['Name'] . '</h3>';
                                        echo '<p>' . $item['Description'] . '</p>';
                                  echo '</div>';
                             echo '</div>';
                         echo '</div>';
                         
                          }
                        echo '</div>';
                    }else{
                    echo 'soory there\' no ads to show, create <a href="newad.php">new ads</a> ';
                    }
                          ?>
                 </div>
           </div>
      </div>
 </div>

 <div class="my-comments block">
       <div class="container">
           <div class="panel panel-primary">
               <div class="panel-heading">Latest Comments </div>
               <div class="panel-body">
                <?php
                $stmt = $con->prepare("SELECT comment FROM comments WHERE  user_id = ? ");
                $stmt->execute(array($info['userid']));
                $comments = $stmt->fetchAll();

                if(! empty($comments)){
                foreach($comments as $comment){
                echo '<p>' . $comment['comment'] .'</p>';
                }
                }else{
                echo 'There\'s No comment to show ';
                }?>
                </div>
          </div>
      </div>
 </div>

<?php }else{
header('location: login.php');
exit();
}

include $tpl . 'footer.php';
?>