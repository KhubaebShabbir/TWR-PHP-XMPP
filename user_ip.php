<?php require_once ('includes/connection.php');

$ip = array();
if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
//check for ip from share internet
$ip["user_ip"] = $_SERVER["HTTP_CLIENT_IP"];
} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
// Check for the Proxy User
$ip["user_ip"] = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
$ip["user_ip"] = $_SERVER["REMOTE_ADDR"];
}
// compare user's ip block
$Query=mysql_query("SELECT * FROM ofIPblock WHERE ip = '". $ip["user_ip"] ."'") or die(mysql_error());
$compare_ip = mysql_num_rows($Query);
if($compare_ip > 0){
	$ip["user_ip"] = "Blocked";
}
// 	This will print user's real IP Address. does't matter if user using proxy or not.
print $_GET['jsoncallback']. '('.json_encode($ip).')';
?>