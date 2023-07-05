<?php
/*
**Check if user is not activated
**function to check the regstatus of the user
*/

 function checkUserStatus($user){

        global $con;

   $stmtx = $con->prepare("SELECT username , regstatus
                          FROM users
                          WHERE username = ?
                          AND
                              regstatus = 0");
             $stmtx->execute(array($user));
            $status = $stmtx->rowCount();
                     return $status;
       }

/*
**Get categories Function v1.0
**Function To Get  Records From Database 
  */
  function getCat() {
     
    global $con;

    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

    $getCat->execute();

    $cats = $getCat->fetchAll();

    return $cats;
  }
   

/*
**Get items Function v1.0
**Function To Get  items From Database 
  */
  function getitems($where, $value) {
     
    global $con;

    $getitems = $con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY Item_ID DESC");

    $getitems->execute(array($value));

    $items = $getitems->fetchAll();

    return $items;
  }






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
**Get Latest Records Function v1.0
**Function To Get  Latest Items From Database [ users, items, comment ]
**$select = Field To Select
**$table = the Table To Choose From 
**$order = the Desc ordering
**$limit = Number of Records To Get
  */
  function getlatest($select,$table, $order,$limit = 5){
    global $con;

    $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $getstmt->execute();

    $rows = $getstmt->fetchAll();

    return $rows;
  }
   