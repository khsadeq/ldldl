<?php
 ob_start();
   session_start();
   $pagetitle ='comment';
if(isset($_SESSION['username'])){
   
    include 'init.php'; 
    include $tpl . 'footer.php';
    $do= isset($_GET['do']) ? $_GET['do'] : 'Manage'; 
            //start manage page
    if($do == 'Manage'){ //manage page
        // select all users except admin
        $stmt = $con->prepare("SELECT comments.*, items.Name as item_name, users.username as members 
                              FROM  comments
                              INNER JOIN
                              items ON
                              items.Item_ID = comments.item_id
                              INNER JOIN
                              users
                              ON
                              users.userid = comments.user_id
                              ORDER BY c_id DESC
                              ");
        //execute the statement
        $stmt->execute();
        // assign to variable
        $rows = $stmt->fetchAll();
        
        if(! empty($rows)){?>
        <h1 class="text-center">Manage Comments</h1>
        <div class="container">
        <div class="tabl-responsive">
        <table class="main-table text-center table table-bordered">
        <tr>
        <td>ID</td>
        <td>Comments</td>
        <td>item name</td>
        <td>user name</dt>
        <td>Added date</td>
        <td>Control</td>
        </tr>
        <tr>
        <?php foreach($rows as $row){
            echo"<tr>";
            echo"<td>" . $row['c_id'] . "</td>";
            echo"<td>" . $row['comment'] . "</td>";
            echo"<td>" . $row['item_name'] . "</td>";
            echo"<td>" . $row['members'] . "</td>";
            echo"<td>" .$row['comment_date'] . "</td>";
            echo"<td>
            <a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
            <a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                if($row['status'] == 0){
                   echo" <a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";
                }
            
            echo"</td>";
            echo"</tr>";}
        ?>
        </tr>
        </table>
        </div>
     </div>
     <?php }else{echo '<div class="container">';
                 echo '<div class="nice-message"> There\'s No Comment To Show </div>';
                
                echo'</div>';
           }?>
      <?php  //echo'welcome you are in Managen page <br/>';
       /////////////////////////////////////////////////////////////////////////////////////// 
    }
    //////////////////////////////////////////////////////////////////////
    elseif($do=='Edit'){  //edit page

        //check if get request userid is numeric & get the integer value of it            
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0; 
        //select all data depend on this id
        $stmt = $con->prepare("SELECT * FROM comments WHERE  c_id = ?");
        //execute query
        $stmt->execute(array($comid));
        //fatch the data
        $row = $stmt->fetch();
        //If there's such id show the form
       $count =  $stmt->rowCount();
      
       if($stmt->rowCount() > 0){ ?>
           <h1 class="text-center"> Edit Comment</h1>
        <div class="container">
           <form class="form-horizontal" action="?do=Update" method="POST">
           <input type="hidden" name="comid" value="<?php echo $row['c_id'] ?>" />
           <!--start Comment field -->
               <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Comment</label>
                 <div class="col-sm-10 col-md-6">
                     <textarea class="fprm-control" name="comment"><?php echo $row['comment'] ?></textarea>
                  </div>
              </div>
      <!--start Comment field -->
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
     elseif($do=='Update'){
        
         echo"<div class='container'>";
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
         echo'<h1 class="text-center"> Update Comment</h1>';

            $comid    = $_POST['comid'];
            $comment  = $_POST['comment'];               
            
            $stmt= $con->prepare("UPDATE comments SET comment = ?  WHERE c_id =? ");
            $stmt->execute(array($comment, $comid));
            // $stmt->execute(array($userid));
            $theMsg ="<div class='alert alert-success'>" .$stmt->rowCount().' Record updated ' ."</div>";
            redirectHome($theMsg, 'back');
         
        }
         else{
             $theMsg ='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
             redirectHome($theMsg);
         }
         echo"</div>";
     }////////////////////////////////////////////////////////////////////////////
     elseif($do == 'Delete'){
        
        echo'<h1 class="text-center"> Delete Comment</h1>';
        echo"<div class='container'>";
        //check if get request userid is numeric & get the integer value of it            
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0; 
      
     $check = checkitem('c_id', 'comments', $comid);
      //If there's such id show the form
       if($check > 0){ 
    //        //select all data depend on this id
        $stmt = $con->prepare("DELETE FROM comments WHERE  c_id= :zid");

        $stmt->bindParam(":zid", $comid);
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
   }elseif($do == 'Approve') {
                    echo'<h1 class="text-center"> Approve comment</h1>';
                    echo"<div class='container'>";
                    //check if get request userid is numeric & get the integer value of it            
                    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0; 
                    //select all data depend on this id
                $check = checkitem('c_id', 'comments', $comid);
                //If there's such id show the form
                if($check > 0){ 
                //        
                    $stmt = $con->prepare("UPDATE comments SET status =1 WHERE  c_id= ?");
                // echo'good this id is  exist';
                    $stmt->execute(array($comid));
                    $theMsg ="<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approve</div>';
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
