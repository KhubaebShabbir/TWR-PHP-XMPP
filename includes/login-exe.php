<?php require_once ('connection.php');

if(isset($_POST['x']) && isset($_POST['z'])){
	$username=$_POST['x'];
	
	$query_name=mysql_query("SELECT * FROM ofUser WHERE username='$username'") or die(mysql_error());
	while($row=mysql_fetch_array($query_name)){
		$dbname=$row['username'];
	};
	
	$name_rows = mysql_num_rows($query_name);
	if($name_rows==1){
		$query_role=mysql_query("SELECT * FROM ofRoles WHERE username='$username'") or die(mysql_error());
		while($row=mysql_fetch_array($query_role)){
			$dbrole=$row['role'];
		};

		$role_rows = mysql_num_rows($query_role);
		if($role_rows==1) {	
			$domain_query=mysql_query("SELECT * FROM ofProperty WHERE name = 'xmpp.domain'");
			while($domain=mysql_fetch_array($domain_query)){
				$domain_name=$domain['propValue'];
			};
			session_start();
			$_SESSION["logged_in"] = 1;
			$_SESSION["user"]=$dbname;
			$_SESSION["role"]=$dbrole;
			$_SESSION['domain']=$domain_name;

			echo 'True';
		} else {
			echo 'User Role is not defined';
		}
	} else {
		echo 'Incorrect Username or Password';
	}
};
mysql_close();
?>