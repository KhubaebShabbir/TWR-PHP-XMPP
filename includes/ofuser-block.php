<?php require_once 'global.inc.php'; ?>

<ul class="content-options">
    <li class="total"></li>
    <li><a class="reload" href="includes/ofuser.php" >View Users</a></li>
    <li><a class="reload" href="includes/ofuser-client.php" >View Clients</a></li>
    <li><a class="reload" href="includes/ofuser-ipblock.php" >View IP Blocked</a></li>
    <li><a class="edit" href="includes/ofuser-add.php" title="Add User"><img src="assets/img/add-agent.png" alt="Add User" /></a></li>
    <li><a id="user-reload" class="reload" href="includes/ofuser-block.php" title="Reload"><img src="assets/img/refresh.png" alt="Reload" /></a></li>
</ul>
<div class="tab-content-full">
  <h2>Users Blocked</h2>
  <?php
$query=mysql_query("SELECT * FROM ofUserFlag") or die(mysql_error());
$totalrows = mysql_num_rows($query);
	echo "<script type=\"text/javascript\">
			$('li.total').text('Total Users: ".$totalrows."')
		</script>";
?>
  <table id="users-area" class="table-list">
    <thead>
    <th class="deepY">Username</th>
      <th class="green">Role</th>
      <th class="blue">Start Time</th>
      <th class="purple">Un Block</th>
      <th class="red">Delete</th>
        </thead>
      <?php
while($row=mysql_fetch_array($query)){
	
	$a=$row['username'];
	$e = $row['startTime']/1000;
	$eDate=date("M, d Y H:i A", $e);
	$r_query=mysql_query("SELECT * FROM ofRoles WHERE username = '$a' AND role !=9");
	while($x=mysql_fetch_array($r_query)){
		$role=$x['role'];
		
	echo '<tr><td>'.$a.'</td>';
	echo '<td class="text-center">'.$role.'</td>';
	echo '<td class="text-center">'.$eDate.'</td>';
	echo '<td class="text-center"><a class="delete" href="includes/ofuser-block-delete.php?id='.$a.'"><img src="assets/img/block.png" alt="Block"></a></td>';
	echo '<td class="text-center"><a class="delete" href="includes/ofuser-delete.php?id='.$a.'"><img src="assets/img/delete.png" alt="Delete"></a></td></tr>';
};
};
?>
  </table>
</div>
