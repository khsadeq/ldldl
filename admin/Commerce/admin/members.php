<?php
 ob_start();
   session_start();
   $pagetitle ='Members';
if(isset($_SESSION['username'])){
   
    include 'init.php'; 
    include $tpl . 'footer.php';
    $do= isset($_GET['do']) ? $_GET['do'] : 'Manage'; 
            //start manage page
    if($do == 'Manage'){ //manage page
        $query='';
        if(isset($_GET['page']) && $_GET['page'] == 'pending'){
            $query='AND regstatus = 0';
        }
        // select all users except admin
        $stmt = $con->prepare("SELECT * FROM users WHERE groupid != 1 $query ORDER BY userid DESC");
        //execute the statement
        $stmt->execute();
        // assign to variable
        $rows = $stmt->fetchAll();
        
        if(! empty($rows)){
            ?>
        <h1 class="text-center">Manage Member</h1>
        <div class="container">
        <div class="tabl-responsive">
        <table class="main-table text-center table table-bordered">
        <tr>
        <td>#ID</td>
        <td>Username</td>
        <td>Email</td>
        <td>fullname</dt>
        <td>Registerd date</td>
        <td>Control</td>
        </tr>
        <tr>
        <?php foreach($rows as $row){
            echo"<tr>";
            echo"<td>" . $row['userid'] . "</td>";
            echo"<td>" . $row['username'] . "</td>";
            echo"<td>" . $row['email'] . "</td>";
            echo"<td>" . $row['fullname'] . "</td>";
            echo"<td>" .$row['Date'] . "</td>";
            echo"<td>
            <a href='members.php?do=Edit&userid=" . $row['userid'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
            <a href='members.php?do=Delete&userid=" . $row['userid'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                if($row['regstatus'] == 0){
                   echo" <a href='members.php?do=Activate&userid=" . $row['userid'] . "' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";
                }
            
            echo"</td>";
            echo"</tr>";}
        ?>
        </tr>
        </table>
        </div>
        <a href="?do=Add" class="add btn btn-primary"><i class='fa fa-plus'></i> new Member </a>
        </div>
        <?php }else{echo '<div class="container">';
                    echo '<div class="nice-message"> There\'s No Members To Show </div>';
                    echo ' <a href="?do=Add" class="add btn btn-primary"><i class="fa fa-plus"></i> new Member </a>';
                    echo'</div>';
           }?>
      <?php   //echo'welcome you are in Managen page <br/>';
       /////////////////////////////////////////////////////////////////////////////////////// 
    }
    elseif($do == 'Add'){ //echo'welcome you are in Add page'; ?>
        
                    <h1 class="text-center">Add New Member</h1>
                    <div class="container">
                    <form class="form-horizontal" action="?do=insert" method="POST">
                    <!--start username field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">username</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username" class="form-control"  required="required" placeholder="username to login into shop" autocomplete="off" />
                            </div>
                        </div>
                <!--start username field -->
                <!--start password field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">password</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="password must be hard & complex" />
                            <i class="show-pass fa  fa-eye fa-2x"></i>
                        </div>
                    </div>
            <!--start password field -->
                <!--start Email field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" class=" form-control" required="required"  placeholder="Email must be valid" />
                    </div>
                    </div> 
                    <!--     -->
                    <!--start Email field -->
                    <!--start full name field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" class="form-control" required="required"  placeholder="Full name in your profile page"/>
                    </div>
                    </div>
            <!--start full name field -->
                <!--start submit field -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
                    </div>
                    </div>
            <!--start submit field -->
                </form>
                    </div>
<?php ///////////////////////////////////////////////////////////
  }elseif($do == 'insert'){
      
            
            echo"<div class='container'>";
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo'<h1 class="text-center"> Insert Member</h1>';
                    //get variables from the form
               
                $user     =  $_POST['username'];
                // $pass     =  $_POST['password'];
                $hashpass =  sha1($_POST['password']);
                $email    =  $_POST["email"];
                $name     =  $_POST['full'];
                
               //validate the trick $formerror
            //    $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
               $formerror = array();
               if(strlen($user) < 4){
                $formerror[]='username cant be less than <strong>4 characters</strong>';  
                }
                if(strlen($user) > 20){
                $formerror[]='username cant be more than<strong> 20 characters</strong>';  
                }  
                
                if(empty($user)){
                    $formerror[]='username cant be<strong> empty</strong>';  
                }
                if(empty($name)){
                    $formerror[]='full name cant be<strong> empty</strong>';    
                }
                if(empty($email)){
                    $formerror[]='email cant be <strong>empty</strong>';                
                }
                foreach($formerror as $error){
                    $theMsg = '<div class="alert alert-danger">'. $error . '</div>';
                    redirectHome($theMsg, 'back');
                }
            
                  if(empty($formerror)){
                    $check = checkitem("username", "users", $user);
                    
                    if($check == 1){
                        $theMsg ="<div class='alert alert-danger'>Sorry this user is Exist</div>";
                        redirectHome($theMsg, 'back');
                    
                    }else{
                    $stmt = $con->prepare("INSERT INTO users(username, password, email, fullname, regstatus,Date)
                                                    VALUES(:zuser, :zpass, :zemail, :zname, 1,now())");
                    $stmt->execute(array(
                        'zuser'  =>  $user ,
                        'zpass'  =>  $hashpass ,
                        'zemail' =>  $email ,
                        'zname'  =>  $name
                    ));
                //     echo'username cant be empty';                
                    // echo $id . $user . $email . $name 
                // $stmt->execute(array($userid));
                $theMsg ="<div class='alert alert-success'>" .$stmt->rowCount().' Record INSERT ' ."</div>";
                redirectHome($theMsg, 'back');
            }}
            }
            else{
                $theMsg= '<div class="alert alert-danger"> sorry you cant browse this page directly </div>';
                
                redirectHome($theMsg);
            }
            echo"</div>";
        


   }
    //////////////////////////////////////////////////////////////////////
    elseif($do=='Edit'){  //edit page

        //check if get request userid is numeric & get the integer value of it            
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 
        //select all data depend on this id
        $stmt = $con->prepare("SELECT * FROM users WHERE  userid=? LIMIT 1");
        //execute query
        $stmt->execute(array($userid));
        //fatch the data
        $row = $stmt->fetch();
        //If there's such id show the form
       $count =  $stmt->rowCount();
      
       if($stmt->rowCount() > 0){ ?>
           <h1 class="text-center"> Edit Member</h1>
        <div class="container">
           <form class="form-horizontal" action="?do=update" method="POST">
           <input type="hidden" name="userid" value="<?php echo $row['userid'] ?>" />
           <!--start username field -->
               <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">username</label>
                 <div class="col-sm-10 col-md-6">
                    <input type="text" name="username" class="form-control"   value="<?php echo $row['username'] ?>" required="required" />
                  </div>
              </div>
      <!--start username field -->
      <!--start password field -->
       <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">password</label>
            <div class="col-sm-10 col-md-6">
                <input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />
                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="leave lank if you dont want to change" />
            </div>
          </div>
   <!--start password field -->
    <!--start Email field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10 col-md-6">
              <input type="email" name="email" class="form-control" value="<?php echo $row['email']?>" required="required" />
         </div>
          </div> 
          <!--     -->
           <!--start Email field -->
           <!--start full name field -->
        <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">full name</label>
        <div class="col-sm-10 col-md-6">
              <input type="text" name="full" class="form-control" value="<?php echo $row['fullname']?>" required="required" />
         </div>
          </div>
   <!--start full name field -->
    <!--start submit field -->
    <div class="form-group form-group-lg">
        <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" value="save" class="btn btn-primary btn-lg" />
         </div>
          </div>
   <!--start submit field -->
       </form>
          </div>
        <?php   
         //if there's no such id show error manage  
     }else{echo'<div class="container">';
          $theMsg =" <div class='alert alert-danger'>theres no such id</div>" ;
          redirectHome($theMsg);
          echo'</div>';
       }
        
     }###########################################################################
     elseif($do=='update'){
        
         echo"<div class='container'>";
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
         echo'<h1 class="text-center"> Update Member</h1>';

            $id    = $_POST['userid'];
            $user  = $_POST['username'];
            $email = $_POST["email"];
            $name  = $_POST['full'];
            //password trick
            $pass= empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
            $formerror = array();
            if(strlen($user) < 4){
                $formerror[]='username cant be less than <strong>4 characters</strong>';  
            }
            if(strlen($user) > 20){
                $formerror[]='username cant be more than<strong> 20 characters</strong>';  
            }
            if(empty($user)){
                $formerror[]='username cant be<strong> empty</strong>';  
            }
            if(empty($name)){
                $formerror[]='full name cant be<strong> empty</strong>';    
            }
            if(empty($email)){
                $formerror[]='email cant be <strong>empty</strong>';                
            }
            foreach($formerror as $error){
             $theMsg ='<div class="alert alert-danger">'. $error . '</div>';
                redirectHome($theMsg, 'back');
            }
        
            if(empty($formerror)){
            //     echo'username cant be empty';                
            
            
                $stmt2 = $con->prepare("SELECT * FROM users
                                                WHERE username = ?
                                                AND userid != ? ");
                                                
                    $stmt2->execute(array($user, $id));

                    $count = $stmt2->rowCount();
                    if($count == 1){
                        $theMsg = '<div class="alert alert-danger"> Sorry This user Is Exist </div> ';
                        redirectHome($theMsg, 'back');
                    }else{
                        $stmt= $con->prepare("UPDATE users SET username = ?, email = ?, fullname = ?, password= ? WHERE userid =? ");
                        $stmt->execute(array($user, $email, $name, $pass, $id));
                        // $stmt->execute(array($userid));
                        $theMsg ="<div class='alert alert-success'>" .$stmt->rowCount().' Record updated ' ."</div>";
                        redirectHome($theMsg, 'back');   
                    }
            
         }
        }
         else{
             $theMsg ='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
             redirectHome($theMsg);
         }
         echo"</div>";
     }////////////////////////////////////////////////////////////////////////////
     elseif($do == 'Delete'){
        
        echo'<h1 class="text-center"> Delete Member</h1>';
        echo"<div class='container'>";
        //check if get request userid is numeric & get the integer value of it            
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 
        // $stmt = $con->prepare("SELECT * FROM users WHERE  userid=? LIMIT 1");
    //     //execute query
        // $stmt->execute(array($userid));
    //   the row count
    //    $count =  $stmt->rowCount();
     $check = checkitem('userid', 'users', $userid);
      //If there's such id show the form
       if($check > 0){ 
    //        //select all data depend on this id
        $stmt = $con->prepare("DELETE FROM users WHERE  userid= :zuser");

        $stmt->bindParam(":zuser", $userid);
    // echo'good this id is  exist';
        $stmt->execute();
        $theMsg ="<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
        redirectHome($theMsg, 'back');
       }
       else{
           $theMsg ='<div class="alert alert-danger">This ID IS Not Exist</div>';
           redirectHome($theMsg);
       }
       echo'</div>';
   }elseif($do == 'Activate') {
                    echo'<h1 class="text-center"> Activate Member</h1>';
                    echo"<div class='container'>";
                    //check if get request userid is numeric & get the integer value of it            
                    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 
                    //select all data depend on this id
                $check = checkitem('userid', 'users', $userid);
                //If there's such id show the form
                if($check > 0){ 
                //        
                    $stmt = $con->prepare("UPDATE users SET regstatus =1 WHERE  userid= ?");
                // echo'good this id is  exist';
                    $stmt->execute(array($userid));
                    $theMsg ="<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activate</div>';
                    redirectHome($theMsg, 'back');
                }
                else{
                    $theMsg ='<div class="alert alert-danger">This ID IS Not Exist</div>';
                    redirectHome($theMsg);
                }
                echo'</div>';
                }

    include $tpl . 'footer.php';
    
       }else{
    
    header('location: index.php');
    
    exit();
}
ob_end_flush();
