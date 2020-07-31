<?php include('../function/function.php');
session_unset();
session_destroy();
ReDirect(AdminHomeUrl());
?>