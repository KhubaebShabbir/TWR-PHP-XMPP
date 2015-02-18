<?php 
// check if session isset

?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TWR | Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
    <script src="assets/js/jquery-1.10.1.min.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/js/jquery.timer.js"></script>
    <script src="assets/js/strophe.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/chat.js"></script>
</head>
<body>
<!-- login dialog -->
<div class="loginbox clrfix">
  <div class="half" style="text-align:center"> <img src="assets/img/webReps-logo.png" alt="" /> <br />
    <h3>Live Website Representatives</h3>
  </div>
  <div class="half last">
    <h4 class="green"> Please Login with your USERNAME and PASSWORD </h4>
    <form id="login-form" method="post" action="includes/login-exe.php">
      <label> Username </label>
      <input type="text" name="x" />
      <br />
      <label> Password </label>
      <input type="password" name="z" />
      <br />
      <label> &nbsp; </label>
      <input type="submit" value="login" />
      <br />
      <label> &nbsp; </label>
      <span class="error"> </span> <br />
      <label> &nbsp; </label>
      <span class="xmpp-status"> </span>
    </form>
  </div>
</div>
</body>
</html>
