<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="jquery.js"></script>
	<link rel="shortcut icon" href="mainsite.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="style/index.css">
	<title>foliage Bet</title>
	<script type="text/javascript">
	function showLogin(){
		$("#login").toggle(1);
	}
	</script>
</head>
<body>

<div id="header">
	<span id="#">
		<div id="hellouser">Hello, <?php if($_SESSION['channel']!=null){echo $_SESSION['channel'];}else{echo "User";}?>!</div>
		<?php if($_SESSION['auth']){echo '<a href="you" id="but">Home</a>';}else{echo '<a onclick="showLogin()" id="but">Log in</a>';}?>
	</span>
</div>
<div>
	<a href="https://api.twitch.tv/kraken/oauth2/authorize?client_id=mzlft0v6ifnuwqtmzlj74h3gdhvg5j&redirect_uri=http://foliage-bet.com/account&response_type=token&scope=viewing_activity_read">
		<div id="login"></div>
	</a>
</div>
</body>
</html>
	
