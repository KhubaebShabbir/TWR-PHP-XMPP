<?php require_once 'global.inc.php'; ?>

<?php
function getChildren($id) {
  $sql = mysql_query("SELECT * FROM ofUserFolders WHERE username = '".$_SESSION['user']."' AND parent_id = '$id'") or die(mysql_error());
  echo "<ul class='chat-pCnd'>";
  while($row = mysql_fetch_array($sql)) {
    echo "<li>{$row['folderName']}";
  	
	$msgs_query = mysql_query("SELECT * FROM ofUserCanned WHERE folder_id = '{$row['id']}'") or die(mysql_error());
  	while($msgs_row = mysql_fetch_array($msgs_query)) {
		$aa=$msgs_row['type'];
		if($aa == '1'){
			echo "<div class='chat-pCnd-msg'><a href='".$msgs_row['text']."' target='_blank'>".$msgs_row['text']."</a></div>";
		}else{
			echo "<div class='chat-pCnd-msg'>".$msgs_row['text']."</div>";
		}
	}
    getChildren($row['id']);
    echo "</li>";
  }
  echo "</ul>";
}

$id_query = mysql_query("SELECT * FROM ofUserFolders WHERE username = '".$_SESSION['user']."' AND parent_id is NULL") or die (mysql_error());
	if(mysql_num_rows($id_query)) {
	$rowID = mysql_fetch_array($id_query);
	$folderID = $rowID['id'];
	getChildren($folderID);
	} else {
		echo "Please create personal canned messaages in canned msgs tabs";
	}
?>
