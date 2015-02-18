<?php require_once ('connection.php'); ?>
  
<option value=''>All</option>
<?php
$query=mysql_query("SELECT * FROM ofRoles WHERE role != 9") or die(mysql_error());
while($row=mysql_fetch_array($query)){
	$a=$row['username'];
	echo "<option value='".$a."'>".$a."</option>";
}; ?>
