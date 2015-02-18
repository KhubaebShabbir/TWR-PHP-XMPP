<?php require_once 'includes/global.inc.php'; ?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TWR | Dashboard</title>
<link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen" />
<script src="assets/js/jquery-1.10.1.min.js"></script>
<script src="assets/js/jquery.cookie.js"></script>
<script src="assets/js/jquery.timer.js"></script>
<script src="assets/js/strophe.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="assets/js/chat.js"></script>
<script type="text/javascript">
$(function(){
$(document).trigger('attach', cookie_data);
var welcomeText = wRep.jid_to_name(wRep.connection.jid);
$('span.user-btn').append(welcomeText);
});
</script>
</head>
<body>
<div class="wrapper">
  <ul id="left-menu" class="main-nav">
    <?php	if($_SESSION["role"] == 0) { ?>
    <li class="logo"><a href="http://domain.com" target="_blank"><img src="assets/img/webReps.png" /></a></li>
    <li><a href="includes/ofnotifications.html"><img src="assets/img/alerts.png" alt="Notifications"><span>Notifications</span></a></li>
    <li><a href="includes/ofuser-canned.php"><img src="assets/img/user_canned.png" alt="Canned-Msgs"><span>Canned Msgs</span></a></li>
    <li><a href="includes/ofuser.php"><img src="assets/img/users.png" alt="Users"><span>Users</span></a></li>
    <li><a href="includes/ofgroup.php"><img src="assets/img/groups.png" alt="Groups"><span>Groups</span></a></li>
    <li><a href="includes/ofmonitor.html"><img src="assets/img/monitor.png" alt="Monitoring"><span>Monitoring</span></a></li>
    <li><a href="includes/ofworkgroup.php"><img src="assets/img/deployment.png" alt="Deployment"><span>Deployment</span></a></li>
    <li><a href="includes/oftranscript.php"><img src="assets/img/transcripts.png" alt="Transcripts"><span>Transcripts</span></a></li>
    <li><a href="includes/ofsettings.php"><img src="assets/img/process.png" alt="Settings"><span>Settings</span></a></li>
    <?php
} else if($_SESSION["role"] == 1) { ?>
    <li class="logo"><a href="http://domain.com" target="_blank"><img src="assets/img/webReps.png" /></a></li>
    <li><a href="includes/ofnotifications.html"><img src="assets/img/alerts.png" alt="Notifications"><span>Notifications</span></a></li>
    <li><a href="includes/ofuser-canned.php"><img src="assets/img/user_canned.png" alt="Canned-Msgs"><span>Canned Msgs</span></a></li>
    <li><a href="includes/ofworkgroup.php"><img src="assets/img/deployment.png" alt="Team"><span>Deployment</span></a></li>
    <li><a href="includes/ofmonitor.html"><img src="assets/img/monitor.png" alt="Team"><span>Monitoring</span></a></li>
    <?php
} else if($_SESSION["role"] == 2) { ?>
    <li class="logo"><a href="http://domain.com" target="_blank"><img src="assets/img/webReps.png" /></a></li>
    <li><a href="includes/ofnotifications.html"><img src="assets/img/alerts.png" alt="Notifications"><span>Notifications</span></a></li>
    <li><a href="includes/ofuser-canned.php"><img src="assets/img/user_canned.png" alt="Canned-Msgs"><span>Canned Msgs</span></a></li>
    <li><a href="includes/ofuser.php"><img src="assets/img/users.png" alt="Team"><span>Users</span></a></li>
    <li><a href="includes/ofgroup.php"><img src="assets/img/deployment.png" alt="Team"><span>Groups</span></a></li>
    <li><a href="includes/ofworkgroup.php"><img src="assets/img/deployment.png" alt="Team"><span>Deployment</span></a></li>
    <?php			
} else if($_SESSION["role"] == 3) { ?>
    <li class="logo"><a href="http://domain.com" target="_blank"><img src="assets/img/webReps.png" /></a></li>
    <li><a href="includes/ofnotifications.html"><img src="assets/img/alerts.png" alt="Notifications"><span>Notifications</span></a></li>
    <li><a href="includes/ofuser-canned.php"><img src="assets/img/user_canned.png" alt="Canned-Msgs"><span>Canned Msgs</span></a></li>
    <?php	} ?>
  </ul>
  <div class="header">
    <div class="head-bar">
      <h1> Web Reps <span id="stopwatchTabs">00:00:00</span></h1>
      <img id="ajaxLoading" src="assets/img/gif-load.gif" alt="Loading..." /> <span class="user-btn"> <img id="presence" alt="online" src="assets/img/available.png" /> Welcome </span> <span class="xmpp-status"></span><span id="stopwatchPres">00:00:00</span> </div>
    <div class="user-bar">
      <div class="arrowUp"></div>
      <div class="user-panel-top">
        <ul id="presStatus">
          <li class="online"><img src="assets/img/available.png" alt="Available" /><img>Online</li>
          <li class="break"><img src="assets/img/break.png" alt="break" />Break</li>
          <li class="meeting"><img src="assets/img/break.png" alt="break" />Meeting</li>
          <li class="lunch"><img src="assets/img/break.png" alt="break" />Lunch</li>
        </ul>
        <hr />
        SET FONT SIZE <span id="fontInc" class="btn"> Font size ++ </span> <span id="fontDec" class="btn"> Font size -- </span>
        <hr />
        <a id="user-panel-pass" class="user-chngs" href="includes/ofuser-pass.php"> Change Password </a>
        <div id="mini-form"></div>
      </div>
      <div class="user-panel-bottom"> <span id="jidActive-btn" class="btn">Activa Chats</span> <span id="logout" class="logout-btn">Logout</span> <span id="userbar-close">Close</span> </div>
    </div>
    <ul class="tab-title">
      <li class="active"><a href="">Agent Panel</a></li>
    </ul>
  </div>
  <div class="push-page">
    <div id="results"> </div>
    <span class="close"> <img src="assets/img/close.png" alt="close" title="Close"> Close </span> </div>
  <ul class="tab-content">
    <li class="tab-content" style="display:list-item">
      <div class="per80">
        <ul id='chat-area'>
        </ul>
      </div>
      <div class="tab-content-top robin last">
        <h5><img src="assets/img/bullet.png" alt="Queue" /> Chat Queue</h5>
        <div id="ribbonParent">
          <ul id="ribbon">
          </ul>
        </div>
      </div>
      <div class="tab-content-bottom per20">
        <h5>Browser info</h5>
        <ul id="brwsrinfo">
        </ul>
      </div>
      <div class="tab-content-bottom per30">
        <h5 id="viewHstry">Chat History</h5>
        <div class="hstry-wrapper"></div>
      </div>
      <div class="tab-content-bottom tab-nostyle per50 last">
        <ul class="tabs">
          <li class="tab-active"><img id="reload-canned" src="assets/img/reload-icon.png" alt="Reload" /> Personal Canned</li>
          <li>Domain Canned</li>
        </ul>
        <ul class="tabs-div">
          <li>
            <div class="tab-content-tab">
              <div id="chat-user-canned"> </div>
            </div>
          </li>
          <li>
            <div class="tab-content-tab">
              <div id="chat-workgroup-canned"> </div>
            </div>
          </li>
        </ul>
      </div>
    </li>
  </ul>
  <div class="unmailed-title">Unmailed</div>
  <ul id="unmailed">
  </ul>
  <div class="inhouse-chat-wrapper">
    <div class="inhouse-chat">
    <div class="rosterParent">
      <select id='roster-area'>
      	<option value="">Select</option>
      </select>
      </div>
      <div class="inhouse-chat-area"></div>
      <input type="text" name="inhouse-input" />
    </div>
    <img id="thewebresp-chat" src="assets/img/chat-b.png" alt="virtual-reps"> </div>
</div>
<!--- end of wrapper -->
<div class="tabsTimeParent">
  <ul class="viewTotals">
  </ul>
</div>
<div class="statusTimeParent">
  <ul class="presTotals">
  </ul>
</div>
<div id="payloadParent">
  <div id="payloads-view">
    <div class="payload-float threeQuarter">
      <h5 id="payload-agents" class="blue">Online Agents</h5>
      <ul id="payloads-rep">
      </ul>
    </div>
    <div class="payload-float quarter last">
      <h5 id="payload-domains" class="orange">Active Domains</h5>
      <ul id="payloads-group">
      </ul>
    </div>
    <ul id="monitor">
    </ul>
  </div>
</div>
<div id="tabsxml"></div>
<div id="presxml"></div>
<div id="roomsxml"></div>
<div id="repGroupuserxml"></div>
</body>
</html>