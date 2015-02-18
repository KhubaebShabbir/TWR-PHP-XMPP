<?php require_once ('global.inc.php'); ?>


<ul class="content-options">
	<li id="content-filters"><span><img src="assets/img/search.png" alt="Reload" /> Search</span>
    	<form id="transcripts-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if($_SESSION['role'] <= 2 ) { ?>
            <label class="narrow">Agent</label><select class="narrow" name="agentName"></select><br />
        <?php }; ?>
            <label class="narrow">Domain</label><select class="narrow" name="workgroup"></select><br />
            <label class="narrow">Type</label><select class="narrow" name="type">
            	<option value="Billable">Billable</option>
                <option value="Non-Bilable">Non-Billable</option>
            </select><br />
            <label class="narrow">Name</label><input type="text" class="narrow" name="name" /><br />
            <label class="narrow">Email</label><input type="text" class="narrow" name="email" /><br />
            <label class="narrow">Contact</label><input type="text" class="narrow" name="phone" /><br />
            <label class="narrow">IP</label><input type="text" class="narrow" name="ip" /><br />
            <label class="narrow">&nbsp;</label><input type="submit" class="narrow" name="submit" value="search" />
    	</form>
	</li>
    <li class="total"></li>
    <li><a class="reload" href="includes/oftranscript.php" title="Reload"><img src="assets/img/refresh.png" alt="Reload" /></a></li>
</ul>
<div class="tab-content-full">
  <h2>Transcripts</h2>
  <table id="transcript-area" class="table-list">
    <thead>
    <th class="orange">Agent</th>
      <th class="blue">Domain</th>
      <th class="blue">Type</th>
      <th class="deepY">Client Name</th>
      <th class="deepY">Client Email</th>
      <th class="green">Client phone</th>
      <th class="green">Client IP</th>
      <th class="blue">Send To</th>
      <th class="purple">Date</th>
      <th class="red">View Transcript</th>
        </thead>
<?php
$fields = array('agentName', 'workgroup', 'type', 'name', 'email', 'phone', 'ip');
$conditions = array();
foreach($fields as $field){
	if(isset($_POST[$field]) && $_POST[$field] != '') {
		$conditions[] = "`".$field."` like '%" . mysql_real_escape_string($_POST[$field]) . "%'";
	}
}
$query = "SELECT * FROM ofChatDetail ";
if(count($conditions) > 0) {
	$query .= "WHERE " . implode (' AND ', $conditions); 

	$result = mysql_query($query); 
	$totalrows = mysql_num_rows($result);
	if($totalrows ==  0) {
		echo '<tr><td>No record Found</td></tr>';
	} else {
		echo "<script type=\"text/javascript\">
				$('li.total').text('Total Rows: ".$totalrows."');
			</script>";
	
		while($row=mysql_fetch_array($result)){
			$a=$row['agentName'];
			$b=$row['workgroup'];
			$c=$row['type'];
			$d=$row['name'];
			$e=$row['email'];
			$f=$row['phone'];
			$ip=$row['ip'];
			$g=$row['department'];
			$h=$row['date'] / 1000;
			$hDate=date("M, d Y H:i A", $h);
			$id=$row['chatId'];
		
			echo '<tr><td>'.$a.'</td>';
			echo '<td>'.$b.'</td>';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$d.'</td>';
			echo '<td>'.$e.'</td>';
			echo '<td>'.$f.'</td>';
			echo '<td>'.$ip.'</td>';
			echo '<td>'.$g.'</td>';
			echo '<td>'.$hDate.'</td>';
			echo '<td class="text-center"><a class="edit" href ="includes/oftranscript-view.php?id='.$id.'"><img src="assets/img/detail.png" alt="View"></a></tr>';
		}
	}
} else {
	if($_SESSION['role'] >= 3 ){
		$query = "SELECT * FROM ofChatDetail WHERE agentName ='". $_SESSION['user']."'";
	} else {
		$query = "SELECT * FROM ofChatDetail";
	}
	$result = mysql_query($query);
	$totalrows = mysql_num_rows($result);
	echo "<script type=\"text/javascript\">
			$('li.total').text('Total Rows: ".$totalrows."');
		</script>";

	while($row=mysql_fetch_array($result)){
		$a=$row['agentName'];
		$b=$row['workgroup'];
		$c=$row['type'];
		$d=$row['name'];
		$e=$row['email'];
		$f=$row['phone'];
		$ip=$row['ip'];
		$g=$row['department'];
		$h=$row['date'] / 1000;
		$hDate=date("M, d Y H:i A", $h);
		$id=$row['chatId'];
	
		echo '<tr><td>'.$a.'</td>';
		echo '<td>'.$b.'</td>';
		echo '<td>'.$c.'</td>';
		echo '<td>'.$d.'</td>';
		echo '<td>'.$e.'</td>';
		echo '<td>'.$f.'</td>';
		echo '<td>'.$ip.'</td>';
		echo '<td>'.$g.'</td>';
		echo '<td>'.$hDate.'</td>';
		echo '<td class="text-center"><a class="edit" href ="includes/oftranscript-view.php?id='.$id.'"><img src="assets/img/detail.png" alt="View"></a></tr>';
	}
}
?>

<script type="text/javascript">
<?php if($_SESSION['role'] <= 2 ) { ?>
	$.get('includes/ofuser-list.php', function(data){
		 $('select[name="agentName"]').html(data);
	});
<?php }; ?>
	$.get('includes/ofworkgroup-list.php', function(data){
		 $('select[name="workgroup"]').html(data);
	});
</script>
	</table>
</div>