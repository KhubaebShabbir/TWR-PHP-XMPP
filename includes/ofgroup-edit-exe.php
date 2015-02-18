<?php require_once 'global.inc.php';

$_a = mysql_real_escape_string($_POST["x"]);
$_c = $_POST["a"];
//$_compare_groupname = mysql_query("SELECT * FROM ofGroup WHERE groupName = '$_a'") or die (mysql_error());
//	$d=mysql_num_rows($_compare_groupname);
//	if ($d = 1) {
		$query = mysql_query("UPDATE ofGroup SET groupName='$_a', description='$_c' WHERE groupName = '$_a'") or die(mysql_error());
		echo 'Updated sucessfully';
		
//	};
?>