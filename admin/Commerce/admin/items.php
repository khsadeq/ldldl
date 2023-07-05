<?php

ob_start();
   session_start();
   $pagetitle ='items';
if(isset($_SESSION['username'])){
   
    include 'init.php'; 
    include $tpl . 'footer.php';
    $do= isset($_GET['do']) ? $_GET['do'] : 'Manage'; 


            if($do == 'Manage'){

                                $stmt = $con->prepare("SELECT 
                                                             items.*, categories.Name AS category_name,
                                                              users.username 
                                                      FROM items
                                                     INNER JOIN  categories 
                                                     ON categories.ID = items.Cat_ID
                                                    INNER JOIN users 
                                                    ON users.userid = items.Member_ID
                                                    ORDER BY Item_ID DESC  ");
                                //execute the statement
                                $stmt->execute();
                                // assign to variable
                                $items = $stmt->fetchAll();
                                if(! empty($items)){
                                ?>
                                
                                <h1 class="text-center">Manage Items</h1>
                                <div class="container">
                                <div class="tabl-responsive">
                                <table class="main-table text-center table table-bordered">
                                <tr>
                                <td>#ID</td>
                                <td>Name</td>
                                <td>Description</td>
                                <td>price</dt>
                                <td>Adding Date</td>
                                <td>Category</dt>
                                <td>username</dt>
                                <td>Control</td>
                                </tr>
                                <tr>
                                <?php foreach($items as $item){
                                    echo"<tr>";
                                    echo"<td>" . $item['Item_ID'] .    "</td>";
                                    echo"<td>" . $item['Name'] .        "</td>";
                                    echo"<td>" . $item['Description'] . "</td>";
                                    echo"<td>" .$item['Price'] . "</td>";
                                    echo"<td>" . $item['Add_Date'] .    "</td>";
                                    echo"<td>" . $item['category_name'] .    "</td>";
                                    echo"<td>" . $item['username'] .    "</td>";
                                    echo"<td>
                                    <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                    <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                                        if($item['Approve'] == 0){
                                        echo" <a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";
                                        }
                                    
                                    echo"</td>";
                                    echo"</tr>";}
                                ?>
                                </tr>
                                </table>
                                </div>
                                <a href="?do=Add" class="add btn btn-primary"><i class='fa fa-plus'></i> new Member </a>
                                </div>
                            <?php      }else{echo '<div class="container">';
                                             echo '<div class="nice-message"> There\'s No Items To Show </div>';
                                             echo '<a href="?do=Add" class="add btn btn-primary"><i class="fa fa-plus"></i> new Member </a>';
                                             echo'</div>';

                                                            }?> 
                            <?php  //echo'welcome you are in Managen page <br/>';
                            
            }elseif($do == 'Add'){?>
 
                                <h1 class="text-center">Add New Items</h1>
                                <div class="container">
                                <form class="form-horizontal" action="?do=Insert" method="POST">
                                <!--start Name field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10 col-md-6">
                                            <input type="text" name="name" class="form-control"  required="required" placeholder="Name to login into shop" autocomplete="off" />
                                        </div>
                                    </div>
                            <!--start Name field -->
                            <!--start Description field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="description" class="form-control" required="required"  placeholder="Description of the Item" />
                                    </div>
                                </div>
                        <!--start Description field -->
                            <!--start price field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="price" class="form-control" required="required"  placeholder="Price of the items" />
                                </div>
                                </div> 
                                <!--     -->
                                <!--start price field -->
                                <!--start country field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">country</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="country" class="form-control" required="required"  placeholder="country of made"/>
                                </div>
                                </div>
                        <!--start country field -->
                        <!--start Status field -->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10 col-md-6">
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
                                    <label class="col-sm-2 control-label">Cat</label>
                                <div class="col-sm-10 col-md-6">
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
                        <!--start itemImage field -->
                     
                        <div class="form-group form-group-lg">
                                <div class="col-sm-offset-8 col-sm-13">
                                <input type="file"  class="btn btn-primary btn-lg" name='itemImage' >
                                   <label for="file"> اختيار صورة للمنتج</label>
                                    <input type="f" value="item Image" class="btn btn-primary btn-lg" />
                                </div>
                                </div>
                        <!--start itemImage field -->
                        <!-- start Member field -->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Member</label>
                                <div class="col-sm-10 col-md-6">
                                    <select  name="member">
                                        <option value="0">...</option>
                                    <?php
                                    $stmt= $con->prepare("SELECT * FROM users ");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach($users as $user){
                                    echo"<option value='" . $user['userid'] ."'>" . $user['username'] . "</option>";
                                    }
                                    ?>
                            </select>
                                </div>
                                </div>
                        <!--start Member field -->
                        

                            <!--start submit field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Add items" class="btn btn-primary btn-lg" />
                                </div>
                                </div>
                        <!--start submit field -->
                            </form>
                                </div>

 <?php }elseif($do == 'Insert'){
             
                            echo"<div class='container'>";
                            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                            echo'<h1 class="text-center"> Insert Items</h1>';
                                    //get variables from the form
                            
                                $name        =  $_POST['name'];
                                $desc       =  $_POST['description'];
                                $price       =  $_POST['price'];
                                $country     =  $_POST['country'];
                                $status      =  $_POST['status'];
                                // $IMAGE = $_FILES['itemImage'];
                                // $image_location = $_FILES['itemImage']['tmp_name'];
                                // $image_name = $_FILES['itemImage']['name'];
                                // move_uploaded_file($image_location,'images/'. $image_name);
                                // $image_up = "images/".$image_name;
                                $cat      =  $_POST['cat'];
                                $member      =  $_POST['member'];
                            
                            $formerror = array();
                            if(empty($name)){
                                $formerror[]='Name Cat\'t be<strong> Empty</strong>';  
                                }
                                if(empty($desc)){
                                $formerror[]='Description Cat\'t be <strong> Empty</strong>';  
                                }  
                                
                                if(empty($price)){
                                    $formerror[]='price Cat\'t be<strong> Empty</strong>';  
                                }
                                if(empty($country)){
                                    $formerror[]='Country Cat\'t be<strong> Empty</strong>';    
                                }
                                if($status === 0){
                                    $formerror[]='You Must Choose The<strong>Status</strong>';                
                                } 
                                if($cat === 0){
                                    $formerror[]='You Must Choose The<strong>Cat</strong>';                
                                } 
                                if($member === 0){
                                    $formerror[]='You Must Choose The<strong>Member</strong>';                
                                } 
                                
                                foreach($formerror as $error){
                                    $theMsg = '<div class="alert alert-danger">'. $error . '</div>';
                                 //    redirectHome($theMsg, 'back');
                                }
                            
                                if(empty($formerror)){
                                
                                    $stmt = $con->prepare("INSERT INTO 
                                        items (Name, Description, Price, country_Made, Status, Add_Date, Cat_ID, Member_ID)
                                        VALUES(:zname, :zdesc, :zprice, :zcounrty, :zstatus, now(), :zcat, :zmember)");
                                    $stmt->execute(array(
                                        
                                        'zname'      =>  $name,
                                        'zdesc'      =>  $desc,
                                        'zprice'     =>  $price,
                                        'zcounrty'   =>  $country,
                                        'zstatus'    =>  $status,
                                        //'itemImage' => $image_up; 
                                        'zcat'       =>  $cat,
                                        'zmember'    => $member
                                    ));
                            
                                $theMsg ="<div class='alert alert-success'>" .$stmt->rowCount().' Record INSERT ' ."</div>";
                                redirectHome($theMsg, 'back');
                            }
                            }
                            else{
                                $theMsg= '<div class="alert alert-danger"> sorry you cant browse this page directly </div>';
                                
                                redirectHome($theMsg);
                            }
                            echo"</div>";
                        


            }elseif($do == 'Edit'){
                                    
                                    //check if get request userid is numeric & get the integer value of it            
                                    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 
                                    //select all data depend on this id
                                    $stmt = $con->prepare("SELECT * FROM items WHERE  Item_ID=? ");
                                    //execute query
                                    $stmt->execute(array($itemid));
                                    //fatch the data
                                    $item= $stmt->fetch();
                                    //If there's such id show the form
                                $count =  $stmt->rowCount();
                                
                                if($stmt->rowCount() > 0){ ?>
                                    <h1 class="text-center"> Edit Items</h1>
                                    <div class="container">
                                    <form class="form-horizontal" action="?do=Update" method="POST">
                                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
                                     <!--start Name field -->
                                     <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10 col-md-6">
                                            <input type="text" name="name" class="form-control"  required="required" placeholder="Name to login into shop" value="<?php echo $item['Name'] ?>" />
                                        </div>
                                    </div>
                            <!--start Name field -->
                            <!-- start Description field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="description" class="form-control" required="required"  placeholder="Description of the Item" value="<?php echo $item['Description'] ?>"/>
                                    </div>
                                </div>
                        <!--start Description field -->
                            <!--start Email field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="price" class="form-control" required="required"  placeholder="Price of the items" value="<?php echo $item['Price'] ?>"/>
                                </div>
                                </div> 
                                <!--     -->
                                <!--start Email field -->
                                <!--start country field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">country</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="country" class="form-control" required="required"  placeholder="country of made" value="<?php echo $item['country_Made'] ?>" />
                                </div>
                                </div>
                        <!--start country field -->
                        <!--start Status field -->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10 col-md-6">
                                    <select  name="status">
                                        <option value="0">...</option>
                                        <option value="1" <?php if ($item['Status'] == 1){echo 'selected';} ?>>New</option>
                                        <option value="2" <?php if ($item['Status'] == 2){echo 'selected';} ?>>link New</option>
                                        <option value="3" <?php if ($item['Status'] == 3){echo 'selected';} ?>>used</option>
                                        <option value="4" <?php if ($item['Status'] == 4){echo 'selected';} ?>>very old</option>
                                        <option value="5"></option>
                            </select>
                                </div>
                                </div>
                        <!--start Status field -->
                        <!-- start Cat field -->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10 col-md-6">
                                    <select  name="cat">
                                        <option value="0">...</option>
                                    <?php
                                    $stmt= $con->prepare("SELECT * FROM categories ");
                                    $stmt->execute();
                                    $cats = $stmt->fetchAll();
                                    foreach($cats as $cat){
                                    echo"<option value='" . $cat['ID'] ."'";
                                    if($item['Cat_ID'] == $cat['ID']){ echo 'selected';}
                                    echo">" . $cat['Name'] . "</option>";
                                    }
                                    ?>
                            </select>
                                </div>
                                </div>
                        <!--start Cat field -->
                        <!-- start Member field -->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Member</label>
                                <div class="col-sm-10 col-md-6">
                                    <select  name="member">
                                        <option value="0">...</option>
                                    <?php
                                    $stmt= $con->prepare("SELECT * FROM users ");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach($users as $user){
                                    echo "<option value='" . $user['userid'] ."'";
                                    if($item['Member_ID'] == $user['userid']){ echo 'selected';}
                                    echo">" . $user['username'] . "</option>";
                                    }
                                    ?>
                            </select>
                                </div>
                                </div>
                        <!--start Member field -->
                        

                            <!--start submit field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="save items" class="btn btn-primary btn-lg" />
                                </div>
                                </div>
                        <!--start submit field -->
                            </form>
                                    <?php        $stmt = $con->prepare("SELECT comments.*, users.username as members 
                                                                        FROM  comments
                                                                        
                                                                        INNER JOIN
                                                                        users
                                                                        ON
                                                                        users.userid = comments.user_id
                                                                        WHERE item_id = ?");
                                                //execute the statement
                                                $stmt->execute(array($itemid));
                                                // assign to variable
                                                $rows = $stmt->fetchAll();
                                                if(! empty($rows)){
                                                ?>
                                           <h1 class="text-center">Manage [<?php echo $item['Name'] ?>] Comments</h1>
                                                <div class="container">
                                                <div class="tabl-responsive">
                                                <table class="main-table text-center table table-bordered">
                                                <tr>
                                                        <td>Comments</td>
                                                        <td>user name</dt>
                                                        <td>Added date</td>
                                                        <td>Control</td>
                                                </tr>
                                                <tr>
                                                <?php foreach($rows as $row){
                                                            echo"<tr>";
                                                            echo"<td>" . $row['comment'] . "</td>";
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
                                            </div><?php } ?>
                                </div>

                                    <?php   
                                    //if there's no such id show error manage  
                                }else{echo'<div class="container">';
                                    $theMsg =" <div class='alert alert-danger'>theres no such id</div>" ;
                                    redirectHome($theMsg);
                                    echo'</div>';
                                }
                                        }
            elseif($do == 'Update'){
              
                            echo"<div class='container'>";
                            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                            echo'<h1 class="text-center"> Update Items</h1>';
                                $id      = $_POST['itemid'];
                            $name        =  $_POST['name'];
                            $desc       =  $_POST['description'];
                            $price       =  $_POST['price'];
                            $country     =  $_POST['country'];
                            $status      =  $_POST['status'];
                            $cat      =  $_POST['cat'];
                            $member      =  $_POST['member'];
                        
                        $formerror = array();
                        if(empty($name)){
                            $formerror[]='Name Cat\'t be<strong> Empty</strong>';  
                            }
                            if(empty($desc)){
                            $formerror[]='Description Cat\'t be <strong> Empty</strong>';  
                            }  
                            
                            if(empty($price)){
                                $formerror[]='price Cat\'t be<strong> Empty</strong>';  
                            }
                            if(empty($country)){
                                $formerror[]='Country Cat\'t be<strong> Empty</strong>';    
                            }
                            if($status === 0){
                                $formerror[]='You Must Choose The<strong>Status</strong>';                
                            } 
                            if($cat === 0){
                                $formerror[]='You Must Choose The<strong>Cat</strong>';                
                            } 
                            if($member === 0){
                                $formerror[]='You Must Choose The<strong>Member</strong>';                
                            } 
                                foreach($formerror as $error){
                                $theMsg ='<div class="alert alert-danger">'. $error . '</div>';
                                    redirectHome($theMsg, 'back');
                                }
                            
                                if(empty($formerror)){
                                //     echo'username cant be empty';                
                    
                                $stmt= $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, country_Made= ?, Status = ?, Cat_ID = ?, Member_ID = ?  WHERE Item_ID =? ");
                                $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id));
                                // $stmt->execute(array($userid));
                                $theMsg ="<div class='alert alert-success'>" .$stmt->rowCount().' Record updated ' ."</div>";
                                redirectHome($theMsg, 'back');
                            }
                            }
                            else{
                                $theMsg ='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
                                redirectHome($theMsg);
                            }
                            echo"</div>";

            }
             elseif($do == 'Delete'){
                                    
                                echo'<h1 class="text-center"> Delete item </h1>';
                                echo"<div class='container'>";
                                //check if get request userid is numeric & get the integer value of it            
                                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 
                             
                            $check = checkitem('Item_ID', 'items', $itemid);
                            //If there's such id show the form
                            if($check > 0){ 
                            //        //select all data depend on this id
                                $stmt = $con->prepare("DELETE FROM items WHERE  Item_ID= :zid");

                                $stmt->bindParam(":zid", $itemid);
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
                
            }elseif($do == 'Approve'){
                    
                        echo'<h1 class="text-center"> Approve item </h1>';
                        echo"<div class='container'>";
                        //check if get request userid is numeric & get the integer value of it            
                        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 
                        //select all data depend on this id
                    $check = checkitem('Item_ID', 'items', $itemid);
                    //If there's such id show the form
                    if($check > 0){ 
                    //        
                        $stmt = $con->prepare("UPDATE items SET Approve =1 WHERE  Item_ID= ?");
                    // echo'good this id is  exist';
                        $stmt->execute(array($itemid));
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




