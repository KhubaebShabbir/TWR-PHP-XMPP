<?php require_once 'global.inc.php';

if(isset($_GET['id'])) {
	$deleteID=$_GET['id'];
	$match=mysql_query("DELETE FROM ofUserFlag WHERE username='$deleteID'") or die (mysql_error());
	if($match){
		$query=mysql_query('SELECT * FROM ofUser') or die(mysql_error());
		$totalrows = mysql_num_rows($query);
		echo "Total Users: ".$totalrows;
	}
} 
if (isset($_GET['ip'])) {
	$deleteID=$_GET['ip'];
	$match=mysql_query("DELETE FROM ofIPblock WHERE ip='$deleteID'") or die (mysql_error());
	if($match){
		$query=mysql_query('SELECT * FROM ofIPblock') or die(mysql_error());
		$totalrows = mysql_num_rows($query);
		echo "Total Users: ".$totalrows;
	}
}
?>