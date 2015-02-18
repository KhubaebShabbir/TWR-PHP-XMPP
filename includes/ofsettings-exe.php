<?php require_once 'global.inc.php';

	$a = $_POST['a'];
	$query=mysql_query("UPDATE ofProperty SET propValue='$a' WHERE name='maxCanned'") or die(mysql_error());
	echo "Updated Sucessfully";
?>
