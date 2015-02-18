<?php require_once 'global.inc.php';

$x = $_POST['x'];
$y = mysql_real_escape_string($_POST['y']);
$a = mysql_real_escape_string($_POST['a']);
$ee=time()*1000;
$_query= mysql_query("UPDATE ofUser SET email='$y', name='$a', modificationDate='$ee' WHERE username='$x'") or die (mysql_error());
?>