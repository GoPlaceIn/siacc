<?php
//--utf8_encode --
session_start();
session_destroy();
header("Location:index.php");

?>