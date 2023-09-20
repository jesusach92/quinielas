<?php
session_start();
if(isset($_SESSION['id']))
{
    header("Location: ./pages/admin");
}else{
    header("Location: ./pages/userLogin");
}
?>