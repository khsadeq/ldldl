<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <style>
     body{
            background_color:whitesmoke;
        }
        
        input{
            padding:6px;
            text-align:center;
            font-size:16px;
            border:2px solid black;
            
        }
        aside{
            width:300px;
            font-size:20px;
            text-align:center;
            padding: 10px;
            border: 2px solid black;
            background-color:silver;
            color:white;
        }


    </style>
    
</head>
<body><center>
<aside>
    <form action="" method="post"><br>
    <label>username :</label><br>
    <input type="text" name="username" placeholder="اسم المستخدم" ><br>
    <label>password :</label><br>
    <input type="password" name="password" placeholder="كلمة المرور" ><br>
    <input  type="submit" name="submit" id="sub"><br>
    </form>
    </aside>
</center>
</body>
</html>
<?php

include('config.php');
// $con=mysqli_connect("localhost","root","");
// if($con) 
// echo"connect";
// else
//    echo"not connnnnnect";
    // mysqli_select_db($con,"student");
    ?>
    <?php
    session_start();

if(isset($_POST['submit'])){
    $uname=$_POST['username'];
    $pass=$_POST['password'];
    $sql="SELECT * FROM user WHERE  password='".$pass."' and username='".$uname."'";
    $rr=mysqli_query($con,$sql);
    if(mysqli_num_rows($rr)==0){
       echo "الرجاء التاكد من اسم المستخدم او كلمة المرور ";
        header("location:http://localhost/shope_online/admin/user.php");}
   
        else
        {
       $_SESSION['username'] = $uname;
        header("location:http://localhost/shope_online/admin/kh.php");}
        }
       
?>