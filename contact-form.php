<?php include 'includes/connection.php';

$domain = $_GET['domain'];
$name = $_GET['name'];
$email = $_GET['email'];
$message = " Name: ". $name ."\r\n Email: ". $email ."\r\n Message: ". $_GET['msg'];
$to = 'transcripts@domain.com';

$qry = mysql_query("SELECT * FROM ofUser WHERE username = '$from_domain'");
while ($x=mysql_fetch_array($qry)) {
	$cc = $x["email"];
}

$headers .= 'BCC: '. $cc ."\r\n";
$sendmail = mail($to, $domain .' Contact Form', $message, $headers);
$response = array();
if($sendmail){
	$response['msg'] = 'Thank you, mail sent sucesscully';
} else {
	$response['msg'] = 'error';
}
print $_GET['jsoncallback']. '('.json_encode($response).')';
?>