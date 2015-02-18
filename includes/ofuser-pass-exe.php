<?php require_once 'global.inc.php';
$_a = mysql_real_escape_string($_POST["z"]);
$_b = mysql_real_escape_string($_POST["znew"]);

$_compare_pass=mysql_query("SELECT * FROM ofUser WHERE username='".$_SESSION['user']."' AND plainPassword='$_a'") or die(mysql_error());
if(mysql_num_rows($_compare_pass)){ // compare Username
	$ins_query = mysql_query("UPDATE ofUser SET plainPassword='$_b' WHERE username='".$_SESSION['user']."'") or die(mysql_error());
	echo "Password Updated";
} else {
	echo 'Incorrect Old password';
};
?>
