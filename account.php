<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
	body{
		background: url(../img/logo_dark_darken.png) no-repeat #1a1a1a center;
		background-attachment: fixed;
		background-position: center; 
	}
	#hui{
		width: 500px;
		height: 400px;
		background-image: url(img/mechan.gif);
		margin-left: 30%;
		margin-top: 10%;
		opacity: 0.9;
	}
	</style>
	<script type="text/javascript">
		function getAccessToken(){
			var hash = document.location.hash;
			var temp = hash.split('=');
			var token = temp[1].split('&');
			return token[0];
	}
	function goAccount(){ window.location.replace("http://foliage-bet.com/you?token="+getAccessToken());}
	new function() {setTimeout('goAccount()', 3000)};
	</script>
</head>
<body>
<div id="hui"></div>
<?php $_SESSION['auth']=true;?>
</body>
</html>