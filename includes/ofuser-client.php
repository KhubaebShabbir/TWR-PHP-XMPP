<?php require_once 'global.inc.php'; ?>

<ul class="content-options">
    <li class="total"></li>
    <li> <a class="reload" href="includes/ofuser.php" >View Users</a> </li>
    <li><a class="reload" href="includes/ofuser-block.php" >View Blocked</a></li>
    <li><a class="reload" href="includes/ofuser-ipblock.php" >View IP Blocked</a></li>
    <li><a class="edit" href="includes/ofuser-add.php" title="Add User"><img src="assets/img/add-agent.png" alt="Add User" /></a></li>
    <li><a id="user-reload" class="reload" href="includes/ofuser-client.php" title="Reload"><img src="assets/img/refresh.png" alt="Reload" /></a></li>
</ul>
<div class="tab-content-full">
  <h2>Clients</h2>
  <?php
	$query = mysql_query("SELECT * from ofRoles WHERE role = 9");
	$totalrows = mysql_num_rows($query);
	echo "<script type=\"text/javascript\">
			$('li.total').text('Total Users: ".$totalrows."')
		</script>";
?>
  <table id="users-area" class="table-list">
    <thead>
    <th class="red">Username</th>
      <th class="orange">Name</th>
      <th class="deepY">Email</th>
      <th class="green">Role</th>
      <th class="blue">Creation Date</th>
      <th class="purple">Last Modification Date</th>
      <th class="red">Block</th>
        </thead>
<?php
	while($b=mysql_fetch_array($query)){
		$c=$b["username"];
		$z=$b["role"];
		
		$r_query = mysql_query("SELECT * from ofUser WHERE username = '$c'");
		while($row=mysql_fetch_array($r_query)){
			$g=$row['username'];
			$h=$row['name'];
			$i=$row['email'];
			$j = $row['creationDate']/1000;
			$k=date("M, d Y H:i A", $j);
			$l=$row['modificationDate']/1000;
			$m=date("M, d Y H:i A", $l);

			echo '<tr><td>'.$g.'</td>';
			echo '<td>'.$h.'</td>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$z.'</td>';
			echo '<td>'.$k.'</td>';
			echo '<td>'.$m.'</td>';
			echo '<td class="text-center"><a class="delete" href="includes/ofuser-block-exe.php?id='.$g.'"><img src="assets/img/block.png" alt="Block"></a></td></tr>';
		}
	}
?>
  </table>
</div>