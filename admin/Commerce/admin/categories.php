<?php

// ob_start();

   session_start();

//    $pagetitle ='Categories';

if(isset($_SESSION['username'])){
   
        include 'init.php'; 
        // include $tpl . 'header.php';
        include $tpl . 'footer.php';
        $do= isset($_GET['do']) ? $_GET['do'] : 'Manage'; 

            if ($do == 'Manage'){   
              $sort ='ASC';
              $sort_array = array('ASC', 'DESC');
                
                if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
                    $sort = $_GET['sort'];
                }
                 $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort ");
               
                 $stmt2->execute();
               
               $cats = $stmt2->fetchAll(); 
               if(! empty($cats)){ ?>
              
               <h1 class="text-center">Manage Categories </h1>
               <div class="container categories">
                   <div class="panel panel-default">
                        <div class="panel-heading">Manage Categories
                            <div class="option pull-right">
                                <i class="fa fa-sort"></i>Ordering:[
                                <a  class="<?php if($sort == 'ASC') { echo 'active';} ?>" href="?sort=ASC">Asc</a> 
                                | <a  class="<?php if($sort == 'DESC') { echo 'active';} ?>" href="?sort=DESC">Desc</a>]
                                    <i class="fa fa-eye"></i>View:[
                                     <span class="active" data-view="full">Full</span> |
                                    <span data-view="classic"> Classic</span> 
                                    ]
                            </div>
                        </div>
                            <div class="panel-body">
                            <?php
                            foreach($cats as $cat){
                                echo'<div class="cat">';
                                echo'<div class="hidden-buttons">';
                               echo"  <a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                              echo" <a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                                echo'</div>';
                                echo'<h3>' . $cat['Name'] . '</h3>';
                                echo"<div class='full-view'>";
                                echo"<p>"; if($cat['Description'] == '') { echo'this category has no description'; } else{ echo$cat['Description'];} "</p>";
                                if($cat['Visibility'] == 1) { echo'<span class="visibility cat-span">Hidden</span>'; }
                                if($cat['Allow_comment'] == 1) { echo'<span class="commenting cat-span"> comment disabled</span>'; }  
                                if($cat['Allow_Ads'] == 1) { echo'<span class="advertises cat-span"> ads disabled</span>'; }
                                 echo'</div>';
                                echo'</div>';
                                echo'<hr>';
                            }
                            ?>
                           </div> 
                        </div>
                   <a href="?do=Add" class="add-category btn btn-sm btn-primary"><i class='fa fa-plus'></i> new Member </a>
                  </div>
            </div>
            <?php }else{echo '<div class="container">';
                 echo '<div class="nice-message"> There\'s No Categories To Show </div>';
                 echo '<a href="?do=Add" class="add-category btn btn-sm btn-primary"><i class="fa fa-plus"></i> new Member </a>';
                echo'</div>';
           }?>
           <?php
     }elseif($do == 'Add'){ ?>
                <h1 class="text-center">Add New Category</h1>
                <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST">
                <!--start Name field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" autocomplete="off"  
                            required="required" placeholder="Name of the Category" />
                        </div>
                    </div>
            <!--start Name field -->
            <!--start Description field -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control"  placeholder="Description the Category" />
                    </div>
                </div>
        <!--start Description field -->
            <!--start Ordering field -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="order" class="form-control"  placeholder="Number to Arrange the Category" />
                </div>
                </div> 
                <!--     -->
                <!--start Ordering field -->
                <!--start  Vilibile field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visibile</label>
                <div class="col-sm-10 col-md-6">
                <div>
                <input id="vis-yes" type="radio" name="visibility" value="0" checked>
                <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input id="vis-no" type="radio" name="visibility"  value="1" />
                    <label for="vis-no">No</label>
                    </div>
                </div>
                </div>
        <!--start  Vilibile field -->
        <!--start  Allow_Comment field -->
        <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow_Comment</label>
                <div class="col-sm-10 col-md-6">
                <div>
                <input id="com-yes" type="radio" name="comment" value="0" checked>
                <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="comment"  value="1" />
                    <label for="com-no">No</label>
                    </div>
                </div>
                </div>
        <!--start  Allow_Comment field -->
        <!--start  Allow_Ads field -->
        <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow_Ads</label>
                <div class="col-sm-10 col-md-6">
                <div>
                <input id="ads-yes" type="radio" name="ads" value="0" checked>
                <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input id="ads-no" type="radio" name="ads"  value="1" />
                    <label for="ads-no">No</label>
                    </div>
                </div>
                </div>
        <!--start  Allow_Ads field -->
            <!--start submit field -->
            <div class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Add category" class="btn btn-primary btn-lg" />
                </div>
                </div>
        <!--start submit field -->
            </form>
                </div>             

     <?php
     }elseif($do == 'Insert'){
                echo"<div class='container'>";
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo'<h1 class="text-center"> Insert Category</h1>';
                        //get variables from the form
                   
                    $name      =  $_POST['name'];
                    $desc      =  $_POST['description'];
                    $order     =  $_POST['order'];
                    $visibile  =  $_POST['visibility'];
                    $comment   =  $_POST["comment"];
                    $ads       =  $_POST['ads'];
                   
                        $check = checkitem("Name", "categories", $name);
                        
                        if($check == 1){
                            $theMsg ="<div class='alert alert-danger'>Sorry this categories is Exist</div>";
                            
                            redirectHome($theMsg, 'back');
                        
                        } else {
                        $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_comment, Allow_Ads)
                                  VALUES(:zname, :zdesc, :zorder, :zvisibile, :zcomment, :zads )");
                        $stmt->execute(array(
                            'zname'      =>  $name,
                            'zdesc'      =>  $desc,
                            'zorder'     =>  $order,
                            'zvisibile'  =>  $visibile,
                            'zcomment'  =>  $comment,
                            'zads'       =>  $ads
                        ));
                    $theMsg ="<div class='alert alert-success'>" .$stmt->rowCount().' Record Insert ' ."</div>";
                    redirectHome($theMsg, 'back');
                }
                } else {
                    $theMsg= '<div class="alert alert-danger"> sorry you cant browse this page directly </div>';
                    
                    redirectHome($theMsg);
                }
                echo"</div>";
    
            }elseif($do == 'Edit'){
                        //check if get request catid is numeric & get the integer value of it            
                        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; 
                        //select all data depend on this id
                        $stmt = $con->prepare("SELECT * FROM categories WHERE  ID= ? ");
                        //execute query
                        $stmt->execute(array($catid));
                        //fatch the data
                        $cat = $stmt->fetch();
                        //If there's such id show the form
                        $count =  $stmt->rowCount();
                    
                if($stmt->rowCount() > 0){ ?>
                            <h1 class="text-center">Edit New Category</h1>
                <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="catid" value="<?php echo $catid ?>" />
                <!--start Name field -->

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" autocomplete="off"  
                            required="required" placeholder="Name of the Category" value="<?php echo $cat['Name'] ?>" />
                        </div>
                    </div>
            <!--start Name field -->
            <!--start Description field -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control"  placeholder="Description the Category" value="<?php echo $cat['Description'] ?>" />
                    </div>
                </div>
        <!--start Description field -->
            <!--start Ordering field -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="order" class="form-control"  placeholder="Number to Arrange the Category" value="<?php echo $cat['Ordering'] ?>" />
                </div>
                </div> 
                <!--     -->
                <!--start Ordering field -->
                <!--start  Vilibile field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visibile</label>
                <div class="col-sm-10 col-md-6">
                <div>
                <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0){ echo'checked';} ?> >
                <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input id="vis-no" type="radio" name="visibility"  value="1" <?php if($cat['Visibility'] == 1){ echo'checked';} ?> />
                    <label for="vis-no">No</label>
                    </div>
                </div>
                </div>
        <!--start  Vilibile field -->
        <!--start  Allow_Comment field -->
        <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow_Comment</label>
                <div class="col-sm-10 col-md-6">
                <div>
                <input id="com-yes" type="radio" name="comment" value="0" <?php if($cat['Allow_comment'] == 0){ echo'checked';} ?> />
                <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="comment"  value="1" <?php if($cat['Allow_comment'] == 1){ echo'checked';} ?> />
                    <label for="com-no">No</label>
                    </div>
                </div>
                </div>
        <!--start  Allow_Comment field -->
        <!--start  Allow_Ads field -->
        <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow_Ads</label>
                <div class="col-sm-10 col-md-6">
                <div>
                <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){ echo'checked';} ?> />
                <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input id="ads-no" type="radio" name="ads"  value="1" <?php if($cat['Allow_Ads'] == 1){ echo'checked';} ?> />
                    <label for="ads-no">No</label>
                    </div>
                </div>
                </div>
        <!--start  Allow_Ads field -->
            <!--start submit field -->
            <div class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="save category" class="btn btn-primary btn-lg" />
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
 

            }elseif($do == 'Update'){
                echo"<div class='container'>";
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo'<h1 class="text-center"> Update Category</h1>';
                
                $id       = $_POST['catid'];
                $name      =  $_POST['name'];
                $desc      =  $_POST['description'];
                $order     =  $_POST['order'];
                $visibile  =  $_POST['visibility'];
                $comment   =  $_POST["comment"];
                $ads       =  $_POST['ads'];
                
                   if(empty($formerror)){
                   //     echo'username cant be empty';                
                   
                   
                       // echo $id . $user . $email . $name ;
       
                   $stmt= $con->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ?, Visibility= ?, Allow_comment =?, Allow_Ads=? WHERE ID= ? ");
                   $stmt->execute(array($name, $desc, $order, $visibile, $comment, $ads, $id));
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
            }////////////////////////////////////////////////////////////////////////////
            elseif($do == 'Delete'){
                        
                        echo'<h1 class="text-center"> Delete Member</h1>';
                        echo"<div class='container'>";
                        //check if get request userid is numeric & get the integer value of it            
                        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; 
                        
                        $check = checkitem('ID', 'categories', $catid);
                        //If there's such id show the form
                        if($check > 0){ 
                    //        //select all data depend on this id
                        $stmt = $con->prepare("DELETE FROM categories WHERE  ID = :zid");
                
                        $stmt->bindParam(":zid", $catid);
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
                        
                        

            }elseif($do == 'Update'){
                echo'welcome you are in insert category page';
            }

                include $tpl . 'footer.php';

                
}else{
    
    header('location: index.php');
    
    exit();
}

ob_end_flush();
?>




