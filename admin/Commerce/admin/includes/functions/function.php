<?php
  /*
**
**
**
**
  */
     function gettitle() { 
         global $pagetitle;
       if (isset($pagetitle)) {
            echo $pagetitle;
         } else {
         echo 'Default';
     }
}

 /*
**
**
**
**
  */

          function redirectHome($theMsg, $url = Null, $seconds= 3){
                  if($url === Null){
                   
                    $url = 'index.php';
                   
                    $link = 'Homepage';
                 
                  }else{
                    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
                     
                      $url = $_SERVER['HTTP_REFERER'];
                      
                      $link = 'previousv page';
                    
                    }else{
                      $url = 'index.php';

                      $link = 'Homepage';
                    }
                  
                  }
                  echo $theMsg ;
              //  echo"<div class='alert alert-dander'>$theMsg</div>";

              echo"<div class='alert alert-info'>You Will Be Redirected To $link After $seconds seconde.</div>";

              header("refresh:$seconds;url=$url");

              exit();
          }

 /*
**
**
**
**
  */
function checkitem($select, $from, $value){
     global $con; 

     $statement = $con->prepare("SELECT $select FROM $from WHERE $select= ?");

     $statement->execute(array($value));

     $count =$statement->rowCount();
     
     return $count;
}

/*
**
**
**
**
  */
        function countitems($item, $table){
        
            global $con;
            
            $stmt2 =$con->prepare("SELECT COUNT($item) FROM $table");

            $stmt2 ->execute();

            return $stmt2->fetchColumn();
        }
  
/*
**
**
**
**
  */
  function getlatest($select,$table, $order,$limit = 5){
    global $con;

    $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $getstmt->execute();

    $rows = $getstmt->fetchAll();

    return $rows;
  }
   