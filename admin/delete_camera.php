<?php

include('config.php');
$ID = $_GET['id'];
mysqli_query($con, "DELETE FROM camera_add WHERE id=$ID");
header('location: products_camera.php')

?>