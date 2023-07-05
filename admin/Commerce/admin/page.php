<?php
// $do='';
// if(isset($_GET['do'])){
//     $do=$_GET['do'];
// }else{
//     $do='manage';
// }
ob_start();
   session_start();
   $pagetitle =' ';
if(isset($_SESSION['username'])){
   
    include 'init.php'; 
    $do= isset($_GET['do']) ? $_GET['do'] : 'Manage'; 


            if($do == 'Manage'){
                echo'welcome you are in managen category page';
                echo'<a href="?do=insert">addnew category +</a>';

            }elseif($do == 'Add'){
                echo'welcome you are in Add category page';

            }elseif($do == 'Insert'){
                echo'welcome you are in insert category page';


            }elseif($do == 'Edit'){
                echo'welcome you are in insert category page';
            }
            elseif($do == 'Delete'){
                echo'welcome you are in insert category page';
            }

                include $tpl . 'footer.php';

                
}else{
    
    header('location: index.php');
    
    exit();
}

ob_end_flush();
// elseif(do=='Add'){
//     echo'welcome you are in Add category page';
// }




