<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    body{
            background-color:whitesmoke;
            /* background: #ffffff url("logo.png") no-repeat ; */
        }
       
        .post{
            /* margin-bottom:100px;
            margin-top:100px; */
            display:inline-block;
            
            /* margin-bottom:100px; */
        }
        .img{
            margin-bottom:-70px;
            margin-top:-100; 
        }
        h1{
            margin-bottom:-50px
        }

        a{display:inline-block;
            text-decoration: none;
            width:190px;
            padding:17px;
            font-size:16px;
            font-weight:bold;
            margin:20px;
        }

       
        </style>

</head>
<body>
<?php
  include('config.php');
  session_start();
      $uname = $_SESSION['username'];

      if(!isset($uname)){
      header("location: user.php");
      };
?>

         <center>
         
         <h1>موقع تسوق أون لاين</h1>
         <img src="logo.png" class="img" alt="logo" width="1100px">
         <div class="post"><a href=" index.php" ><img src="9349db88426f7e5a9a7fbe45fa79e480.jpg" while="80px" height="80px"/><div class="price">computer</div></a>

<a href=" index_camera.php" ><img src="camera-icon--reality-icons--softiconsm-29.png" while="80px" height="80px"/><div class="price">camera</div></a>


<a href=" index_earphone.php" ><img src="51s-Op4wJ4L._AC_SY780_.jpg" while="80px" height="80px"/><div class="price">earphone</div></a>

<a href=" index_hour.php" ><img src="3-29_IWC_IW500916_Big Pilot's Watch_Ed_LPP_Front_.jpg" while="80px" height="80px"/><div class="price">hour</div> </a></div>

</center>

        
</body>
</html>