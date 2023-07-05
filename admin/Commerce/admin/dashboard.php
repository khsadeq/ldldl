<?php
   session_start();
   if(isset($_SESSION['username'])){
          $pagetitle='Dashboard';
      include 'init.php';
    include $tpl . 'header.php';
    include $tpl . 'footer.php';
    //start dashboard page
    $numusers = 6;// number of latest users
    $latestusers = getlatest("*","users","userid", $numusers);//latest users array
    $numitems = 6;//    number of latest items
    $latestitems = getlatest("*","items","Item_ID", $numitems);
    $numcomment = 4; // Number of Comment
    
    // echo'welcome' ;
    // print_r($_SESSION);?>
    <div class="home-stats">
    <div class="container  text-center">
      <h1><?php echo $pagetitle; ?></h1>
         <div class="row">
           <div class="col-md-3">
              <div class="stat st-members">
              <i class="fa fa-users"></i>
              <div class="info">
                  Total Members
                  <span>
                    <a href="members.php"><?php echo countitems('userid', 'users') ?></a>
                  </span></div>
              </div>
              </div>
         <div class="col-md-3">
            <div class="stat st-pending">
            <i class="fa fa-user-plus"></i>
              <div class="info">
                pending Members
                <span>
                  <a href="members.php?do=Manage&page=pending"><?php echo checkitem("regstatus", "users", 0 ) ?></a></span></div>
             </div>
   </div>
         <div class="col-md-3">
              <div class="stat st-items">
              <i class="fa fa-tag"></i>
              <div class="info">
                  Total Items
                 <span><a href="items.php"><?php echo countitems('Item_ID', 'items') ?></a></span></div>
              </div>
   </div>
        <div class="col-md-3">
             <div class="stat st-comments">
             <i class="fa fa-comments"></i>
              <div class="info">
                 Total Comments
                 <span><a href="comments.php"><?php echo countitems('c_id', 'comments') ?>
                           </a></span>
            </div>
   </div>
            </div>
       </div>
    </div>
        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <i class="fa fa-users"></i> 
                          Letest<?php echo $numusers ?> Registerd Users
                          <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                         </span>
                        </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                <?php
                                // $thelatest = getlatest("*","users","userid", 5);
                            if(! empty($latestusers)){
                                    foreach ($latestusers as $user) {
                                        echo '<li>' ;
                                        echo $user['username'] ;
                                          echo'<a href="members.php?do=Edit&userid=' . $user['userid'] . '">
                                          <span class="btn btn-success pull-right">
                                          <i class="fa fa-edit"></i>Edit';
                                          if($user['regstatus'] == 0){
                                            echo" <a href='members.php?do=Activate&userid=" . $user['userid'] . "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Activate</a>";
                                        }
                                          
                                      echo' </span></a></li>';
                                    }
                              }else{
                                echo '<div class="container">';
                                echo ' There\'s No Record To Show ';
                                // redirectHome($theMsg, 'back');
                                echo'</div>';
                              }
                             ?>
                               </ul>
                           </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <i class="fa fa-tag"></i> Letest<?php echo $numitems ?> item
                          <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                         </span>
                        </div>
                            <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                // $thelatest = getlatest("*","users","userid", 5);
                              if(! empty($latestitems)){
                                foreach ($latestitems as $items) {
                                    echo '<li>' ;
                                    echo $items['Name'] ;
                                      echo'<a href="items.php?do=Edit&itemid=' . $items['Item_ID'] . '">
                                      <span class="btn btn-success pull-right">
                                      <i class="fa fa-edit"></i>Edit';
                                      if($items['Approve'] == 0){
                                        echo" <a href='items.php?do=Approve&itemid=" . $items['Item_ID'] . "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Approve</a>";
                                    }
                                      
                                   echo' </span></a></li>';
                                }
                              }else{
                                echo '<div class="container">';
                                echo ' There\'s No item To Show ';
                                echo'</div>';
                              }
                             ?>
                               </ul>
                           </div>
                    </div>
                </div>
            </div>
            <!--start latest comment -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <i class="fa fa-comments"></i> 
                          Letest <?php echo $numcomment ?> Comments
                          <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                         </span>
                        </div>
                            <div class="panel-body">
                            <?php 
                                          $stmt = $con->prepare("SELECT comments.*, users.username as members 
                                                                FROM  comments
                                                                INNER JOIN
                                                                   users
                                                                ON
                                                                users.userid = comments.user_id
                                                                ORDER BY c_id DESC
                                                                LIMIT $numcomment
                                                                ");
                              //execute the statement
                              $stmt->execute();
                              // assign to variable
                              $comments = $stmt->fetchAll();
                              if(! empty($comments)){
                                       foreach($comments as $comment)  {
                                         echo'<div class="comment-box">';
                                         echo '<a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
                                          <span class="member-n">' . $comment['members'] .  '</span></a>';
                                         echo '<p class="member-c">' . $comment['comment'] .  '</p>';
                                         echo '</div>';
                                       }            
                                       }else{
                                        echo '<div class="container">';
                                        echo ' There\'s No Comment To Show ';
                                        echo'</div>';
                                       } ?>
                           </div>
                    </div>
                </div>
              </div>
            <!--end latest comment -->
        </div>
     </div>
  <?php
    include $tpl . 'footer.php';
    
}else{
    // echo 'you are not autorized ';
    header('location: index.php');
    exit();
}