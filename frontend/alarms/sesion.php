<?php
session_start();
if(!isset($_SESSION['k_username']))
{
	echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=login.php'>";
    exit();
}
?>