<?php require_once 'global.inc.php';

$aa=$_POST["x"];
$cc=mysql_real_escape_string($_POST["y"]);
$dd=mysql_real_escape_string($_POST["a"]);
$ee=time()*1000;
$ff=$_POST['role'];
$query=mysql_query("UPDATE ofUser SET email='$cc', name='$dd', modificationDate='$ee' WHERE username='$aa'") or die(mysql_error());
if($query){
	$r_query=mysql_query("UPDATE ofRoles SET role='$ff' WHERE username='$aa'") or die(mysql_error());
	echo 'User Updated Sucessfully';
} else {
	echo 'Oops! Something goes wrong. Try again';
};
?>