<?php

include("php/query.php"); 


if (isset($_SESSION['adminEmail'])) {
    unset($_SESSION['adminEmail']);
    unset($_SESSION['adminName']);
    unset($_SESSION['adminId']);
    unset($_SESSION['adminRole']);
}


if (isset($_SESSION['userEmail'])) {
    unset($_SESSION['userEmail']);
    unset($_SESSION['userName']);
    unset($_SESSION['userId']);
    unset($_SESSION['userRole']);
}



echo "<script>alert('Logout successful'); location.assign('index.php');</script>";
?>
