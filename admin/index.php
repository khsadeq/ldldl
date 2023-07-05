<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shope online | اضافة منتجات</title>
    <link rel="stylesheet" href="index.css">
    <style>
    .post{
        display:inline-block;
    }
    a{
        display:inline-block;
            text-decoration: none;
            width:190px;
            /* padding:17px; */
            font-size:18px;
            font-weight:bold;
            /* margin:20px; */
        }
    </style>
</head>
<body>
    <center>
        <div class="main">
            <form action="insert.php" method="post" enctype="multipart/form-data">
                <h2>موقع تسويقي اونلاين</h2>
                <img src="logo.png" alt="logo" width="450px">
                <br>
                الاسم: <input type="text" name='name'>
                <br>
               السعر :<input type="text" name='price'>
                <br>
                <input type="file" id="file" name='image' style='display:none;'>
                <label for="file"> اختيار صورة للمنتج</label>
                <button name='upload'>رفع المنتج ✅</button><br>
                <div class="post">
                <!-- <a href='index_camera.php?'  class='btn btn-danger'>اضافة كاميرا ✅</a>
                    <a href='index_computer.php?'  class='btn btn-primary'>اضافة كمبيوتر✅</a><br>
                    <a href='index_earphone.php?'  class='btn btn-danger'>اضافة سيارة  ✅</a> -->
                    <a href='kh.php?'  class='btn btn-danger'>الصفحة الرئيسية  ✅</a>
                    </div>
                <br><br><?php
                // if(isset($_POST['upload']))
                //         {
                //             header("location:http://localhost/project/shope_online/admin/insert.php");
                //         }
                //             ?>
                <a href="products.php">عرض كل المنتجات</a>
            </form>
        </div>
       
    </center>
</body>
</html>