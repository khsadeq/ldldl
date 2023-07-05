<?php

include('config.php');
$ID = $_GET['id'];
mysqli_query($con, "DELETE FROM earphone_add WHERE id=$ID");
header('location: products_earphone.php')

?>