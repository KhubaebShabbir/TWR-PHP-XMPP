<?php require_once 'global.inc.php'; ?>

<?php
$query=mysql_query("SELECT * FROM ofGroup WHERE groupName != 'thewebreps'") or die(mysql_error());
while($row=mysql_fetch_array($query)){
	$a=$row['groupName'];

	echo "<option value='".$a."'>".$a."</option>";
};
?>