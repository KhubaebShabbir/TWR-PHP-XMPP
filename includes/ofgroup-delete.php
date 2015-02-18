<?php include 'connection.php';

$deleteID=$_GET['id'];
$d_query=mysql_query("DELETE FROM ofGroupUser WHERE groupName='$deleteID'") or die (mysql_error());

if($d_query){
	$match=mysql_query("DELETE FROM ofGroup WHERE groupName='$deleteID'") or die (mysql_error());
	
	if($match) {
		$query=mysql_query('SELECT * FROM ofGroup') or die(mysql_error());
		$totalrows = mysql_num_rows($query);
		echo "Total Groups: ".$totalrows;
	}
};
?>