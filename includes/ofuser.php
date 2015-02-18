<?php require_once 'global.inc.php'; ?>

<ul class="content-options">
    <li class="total"></li>
    <li><a class="reload" href="includes/ofuser-client.php" >View Clients</a></li>
    <li><a class="reload" href="includes/ofuser-block.php" >View Blocked</a></li>
    <li><a class="reload" href="includes/ofuser-ipblock.php" >View IP Blocked</a></li>
    <li><a class="edit" href="includes/ofuser-add.html" title="Add User"><img src="assets/img/add-agent.png" alt="Add User" /></a></li>
    <li><a id="user-reload" class="reload" href="includes/ofuser.php" title="Reload"><img src="assets/img/refresh.png" alt="Reload" /></a></li>
</ul>
<div class="tab-content-full">
  <h2>Users</h2>
<?php
$query=mysql_query("SELECT * FROM ofUser WHERE username NOT IN (SELECT username FROM ofUserFlag) AND username !='". $_SESSION['user']."'") or die(mysql_error());
	$totalrows = mysql_num_rows($query);
	echo "<script type=\"text/javascript\">
			$('li.total').text('Total Users: ".$totalrows."');
		</script>";
?>
  <table id="users-area" class="table-list">
    <thead>
    <th class="red">Username</th>
      <th class="orange">Name</th>
      <th class="deepY">Email</th>
      <th class="deepY">Role</th>
      <th class="purple">Edit</th>
      <th class="purple">Block</th>
      <th class="red">Delete</th>
        </thead>
      <?php
while($row=mysql_fetch_array($query)){
	
	$a=$row['username'];
	$c=$row['name'];
	$d=$row['email'];
	
	$r_query=mysql_query("SELECT * FROM ofRoles WHERE username = '$a' AND role !=9");
	while($x=mysql_fetch_array($r_query)){
		$role=$x['role'];

	echo '<tr><td>'.$a.'</td>';
	echo '<td>'.$c.'</td>';
	echo '<td>'.$d.'</td>';
	echo '<td>'.$role.'</td>';
	echo '<td class="text-center"><a class="edit" href="includes/ofuser-edit.php?id='.$a.'"><img src="assets/img/edit.png" alt="Edit"></a></td>';
	echo '<td class="text-center"><a class="delete" href="includes/ofuser-block-exe.php?id='.$a.'"><img src="assets/img/block.png" alt="Block"></a></td>';
	echo '<td class="text-center"><a class="delete" href="includes/ofuser-delete.php?id='.$a.'"><img src="assets/img/delete.png" alt="Delete"></a></td></tr>';
	};
};

?>
  </table>
</div>