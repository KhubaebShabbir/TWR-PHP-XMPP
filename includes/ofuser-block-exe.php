<?php include 'global.inc.php';

$deleteID=$_GET['id'];
$match=mysql_query("INSERT INTO ofUserFlag (username, name) VALUES ('$deleteID', 'lockout')") or die (mysql_error());

if($match){
	$query=mysql_query('SELECT * FROM ofUser') or die(mysql_error());
	$totalrows = mysql_num_rows($query);
	echo "Total Users: ".$totalrows;
};
?>