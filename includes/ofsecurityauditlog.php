<?php require_once 'global.inc.php'; 

if($_SESSION['role']==0) { ?>

<ul class="content-options">
    <li id="total-logs"></li>
    <li><a class="reload" href="includes/ofsecurityauditlog.php" title="Reload"><img src="assets/img/refresh.png" alt="Reload" /></a></li>
</ul>
<div class="tab-content-top">
  <h2>System Updates Log Viewer</h2>
  <table class="table-list">
    <thead>
    <th class="red">ID</th>
      <th class="orange">Username</th>
      <th class="deepY">Event</th>
      <th class="green">Details</th>
      <th class="blue">Timestamp</th> 
        </thead>
<?php
$query=mysql_query('SELECT * FROM ofSecurityAuditLog ORDER BY msgID DESC LIMIT 99') or die(mysql_error());
$totalrows=mysql_num_rows($query);
	echo "<script type=\"text/javascript\">
			$('#total-logs').html('Records Found: ".$totalrows."')
		</script>";
while($row=mysql_fetch_array($query))
{
	$a=$row['msgID'];
	$b=$row['username'];
	$c=$row['summary'];
	$d=$row['details'];
	$e=$row['entryStamp']/1000;
	$eDate=date("M, d Y H:i A", $e);
	
	echo '<tr><td>'.$a.'</td>';
	echo '<td>'.$b.'</td>';
	echo '<td>'.$c.'</td>';
	echo '<td>'.$d.'</td>';
	echo '<td>'.$eDate.'</td></tr>';
}; ?>
</table>
</div>
<?php }; ?>