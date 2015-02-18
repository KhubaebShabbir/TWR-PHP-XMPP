<?php require_once 'connection.php';

$deleteID=$_GET['id'];
$delID=$_GET['uid'];
$match=mysql_query("DELETE FROM ofGroupUser WHERE username='$deleteID' AND groupName='$delID'") or die (mysql_error());
?>