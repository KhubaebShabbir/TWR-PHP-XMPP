<?php require_once 'global.inc.php';

$_a = mysql_real_escape_string($_POST["x"]);
$_c = $_POST["a"];
$_compare_groupname = mysql_query("SELECT * FROM ofGroup WHERE groupName = '$_a'") or die (mysql_error());
if (mysql_num_rows($_compare_groupname)) {
	echo "Group ". $_a ." already exist";
} else {
	$query = mysql_query("INSERT INTO ofGroup (groupName, description) VALUES ('$_a', '$_c')") or die(mysql_error());
	echo 'Group added sucessfully';
};
?>