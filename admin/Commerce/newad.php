
<?php 
 session_start();
 $pagetitle ='Create New Item';
 include 'init.php';
 
//  echo $sessionuser ;
 if(isset($_SESSION['user'])){
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
 echo $_POST['name'] . '<br>';
 echo $_POST['description'] . '<br>';
 
 
   $formErrors  =  array();
   $name        =  filter_var( $_POST['name'], FILTER_SANITIZE_STRING);
   $desc        =  filter_var($_POST['description'], FILTER_SANITIZE_STRING);
   $price       =  filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
   $country     =  filter_var($_POST['country'], FILTER_SANITIZE_STRING);
   $status      =  filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
   $category    =  filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    
    if(strlen($name) <4){
    $formErrors[]='Items Title Must Be At Least 4 Cheracters';  
    }
    if(strlen($desc) < 10){
    $formErrors[]='Items Description Must Be At Least 10 Cheracters';  
    }  
    
    if(empty($price)){
    $formErrors[]='Items Price Must Be Not Empty';  
    }
    if(strlen($country) <2){
    $formErrors[]='Items Country Must Be At Least 2 Cheracters';    
    }
    if(empty($status)){
    $formErrors[]='Items Status Must Be Not Empty';                
    } 
    if(empty(category)){
    $formErrors[]='Items Category Must Be Not Empty';                
    } 
    
    if(empty($formErrors)){
    
    $stmt = $con->prepare("INSERT INTO 
    items (Name, Description, Price, country_Made, Status, Add_Date, Cat_ID)
    VALUES(:zname, :zdesc, :zprice, :zcounrty, :zstatus, now(), :zcat)");
    $stmt->execute(array(
    
    'zname'      =>  $name,
    'zdesc'      =>  $desc,
    'zprice'     =>  $price,
    'zcounrty'   =>  $country,
    'zstatus'    =>  $status,
    'zcat'       =>  $cat,
    
    ));
     if($stmt){
      echo 'Item Added';
      }
    
    
    }
    
 
 
 }

?>

<h1 class="text-center"> <?php echo $pagetitle ?> </h1>

<div class="information block">
    <div class="container">
         <div class="panel panel-primary">
              <div class="panel-heading"> <?php echo $pagetitle ?> </div>
              <div class="panel-body">
             <div class="row">
             <div class="col-md-8">
             <form class="form-horizontal" action="<?php echo $SERVER['PHP-SELF'] ?>" method="POST">
                                <!--start Name field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input type="text" name="name" class="form-control live"  required="required" placeholder="Name to login into shop" autocomplete="off" data-class=".live-title" />
                                        </div>
                                    </div>
                            <!--start Name field -->
                            <!--start Description field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="description" class="form-control live" required="required"  placeholder="Description of the Item" data-class=".live-desc" />
                                    </div>
                                </div>
                        <!--start Description field -->
                            <!--start price field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Price</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="price" class="form-control live" required="required"  placeholder="Price of the items" data-class=".live-price" />
                                </div>
                                </div> 
                                <!--     -->
                                <!--start price field -->
                                <!--start country field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">country</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="country" class="form-control" required="required"  placeholder="country of made"  />
                                </div>
                                </div>
                        <!--start country field -->
                        <!--start Status field -->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-10 col-md-9">
                                    <select  name="status">
                                        <option value="0">...</option>
                                        <option value="1">New</option>
                                        <option value="2">link New</option>
                                        <option value="3">used</option>
                                        <option value="4">very old</option>
                                        <option value="5"></option>
                            </select>
                                </div>
                                </div>
                        <!--start Status field -->
                        <!-- start Cat field -->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Cat</label>
                                <div class="col-sm-10 col-md-9">
                                    <select  name="cat">
                                        <option value="0">...</option>
                                    <?php
                                    $stmt= $con->prepare("SELECT * FROM categories ");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach($users as $user){
                                    echo"<option value='" . $user['ID'] ."'>" . $user['Name'] . "</option>";
                                    }
                                    ?>
                            </select>
                                </div>
                                </div>
                        <!--start Cat field -->
                        <!--start submit field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="submit" value="Add items" class="btn btn-primary btn-lg">
                                </div>
                                </div>
                        <!--start submit field -->
                            </form>
             </div>
                  <div class="col-md-4">
                    <div class="thumbnail   text-box live-preview">
                    <span class="price-tag live-price">0
                        <!-- <div class="price-teg"></span> -->
                    </span>
                      <img class="img-responsiv" src="[001348].png" alt="" />
                    <div class="caption">
                  <h3 class="live-title"> Title</h3>
                  <p class="live-desc"> Description</p>
                  </div>
             </div>
             </div>
             </div>
            <?php
            //start looping through error 
            //  if(! empty($formErrors)){
            //  foreach($formErrors as $error){
            //  echo '<div class="alert alert-danger">' . $error . '</div>';
            //  }
            //  }
            //end looping through error
            ?>
             
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