<?php
session_start();
if(isset($_SESSION['id']))
{
    header("Location: ./view/index.php");
}else{
    header("Location: ./view/login.php");
}
?>