<?php require_once 'global.inc.php';

$name = $_SESSION['user'];
$v_name = $_POST['info-name'];
$v_email = $_POST['info-email'];
$v_phone = $_POST['info-contact'];
$user_ip = $_POST['ip-address'];
$workgroup = $_POST['wg-name'];
$department = $_POST['selected-depts'];
$type = $_POST['bill-type'];
$date = time()*1000;
$comment = $_POST['comment'];
$chat = $_POST['transcript'] ."\r\n AGENT COMMENTS \r\n". $comment;
$to = 'transcripts@vlivetech.com,'. $_POST['to'];
$cc = $_POST['cc'];
$bcc = $_POST['bcc'];

$query = mysql_query("INSERT INTO ofChatDetail (agentName, type, name, email, phone, ip, workgroup, department, date) VALUES ('$name', '$type', '$v_name', '$v_email', '$v_phone', '$user_ip', '$workgroup', '$department', '$date')");

$select = mysql_query("SELECT * FROM ofChatDetail ORDER BY chatId DESC");
$x = mysql_fetch_array($select);
$id = $x["chatId"];

if ($query){
	$query2 = mysql_query("INSERT INTO ofChat (chatId, chatText) VALUES ('$id', '$chat')");
	echo 'First Inserted';
	if ($query2) { echo 'second inserted'; }
}
else{
	echo 'Something Wrong with Inserting';
}
// subject
$subject = $type ." - ". $workgroup;
// To send HTML mail, the Content-type header must be set
//$headers  = 'MIME-Version: 1.0' . "\r\n";
//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$headers = "webReps - ". $workgroup ."\r\n";
// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
//$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
if(!empty($cc)){
	$headers .= "CC: ". $cc . "\r\n";
}
if (!empty($bcc)){
	$headers .= "BCC: ". $bcc . "\r\n";
}
// Mail it
mail($to, $subject, $chat, $headers);

?>
