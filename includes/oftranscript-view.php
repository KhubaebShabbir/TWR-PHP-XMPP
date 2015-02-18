<?php require_once 'global.inc.php'; ?>

<?php
if(isset($_GET['id'])) {
	$a = $_GET['id'];
	echo "<h4 class='orange'>Transcript</h4>";
	$query=mysql_query("SELECT * FROM ofChat WHERE chatId = '$a'") or die(mysql_error());
	while($row=mysql_fetch_array($query)){
		$chat=$row['chatText'];
	
		echo '<div class="edit-view"><p>'. str_replace("\n", "<br />", $chat) .'</p></div>';
	}
} else {
	$a	= $_POST['id'];
	$detailQuery=mysql_query("SELECT * FROM ofChatDetail WHERE ip = '$a' ORDER BY date DESC" ) or die(mysql_error());
	$ip_rows = mysql_num_rows($detailQuery);
	if($ip_rows > 0){
		while($row=mysql_fetch_array($detailQuery)){
			$chatid=$row['chatId'];
			$date=$row['date'] / 1000;
			$hDate=date("M, d Y H:i A", $date);
			$query=mysql_query("SELECT * FROM ofChat WHERE chatId = '$chatid'") or die(mysql_error());
			while($row=mysql_fetch_array($query)){
				$chat=$row['chatText'];
			
				echo '<div class="hstry-date">'. $hDate .'</div><div class="hstry-view">'. str_replace("\n", "<br />", $chat) .'</div>';
			}
		}
	} else {
		echo "No history record found";
	}
}
?>