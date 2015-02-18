<?php require_once 'global.inc.php'; ?>

<ul class="content-options">
    <li class="total"></li>
    <li><a class="reload" href="includes/ofuser.php" >View Users</a></li>
    <li><a class="reload" href="includes/ofuser-client.php" >View Clients</a></li>
    <li><a class="reload" href="includes/ofuser-block.php" >View Blocked</a></li>
    <li><a class="edit" href="includes/ofuser-add.php" title="Add User"><img src="assets/img/add-agent.png" alt="Add User" /></a></li>
    <li><a id="user-reload" class="reload" href="includes/ofuser-ipblock.php" title="Reload"><img src="assets/img/refresh.png" alt="Reload" /></a></li>
</ul>
<div class="tab-content-full">
  <h2>IP Blocked</h2>
  <?php
$query=mysql_query("SELECT * FROM ofIPblock") or die(mysql_error());
$totalrows = mysql_num_rows($query);
	echo "<script type=\"text/javascript\">
			$('li.total').text('Total Users: ".$totalrows."')
		</script>";
?>
  <table id="users-area" class="table-list">
    <thead>
    <th class="deepY">IP</th>
    <th class="blue">Block By</th>
      <th class="purple">Un Block</th>
        </thead>
      <?php
while($row=mysql_fetch_array($query)){
	$a=$row['ip'];
	$b=$row['username'];
		
	echo '<tr><td>'.$a.'</td>';
	echo '<td>'.$b.'</td>';
	echo '<td class="text-center"><a class="delete" href="includes/ofuser-block-delete.php?ip='.$a.'"><img src="assets/img/delete.png" alt="Delete"></a></td></tr>';
};
?>
  </table>
</div>
