<?php session_start();?>
<?php include_once "auth.php"; include_once "data.php";?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="img/mainsite.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="style/buttons.css">
	<link rel="stylesheet" type="text/css" href="style/account.css">
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript">
	var timeToHide = 750;


	function makeBet(){
		$("#make_bet").toggle(timeToHide);
	}
	function checkMakeBet(){
		var checkbox = $("#checkedagreement").is(":checked");
		var channel = $('#channelinput').val();
		var count = $('#countinput').val();
		if(!checkbox||channel.length==0||count<=0){
			alert('Please fill all fields and confirm the checkbox');
			return false;
		}else{
			document.formMakeBet.submit();
			document.formMakeBet.reset();
			makeBet();
			//add window with success notification
			return false;
		}
	}
	function toggleStartStream(){
		$("#startstream").toggle(timeToHide);
	}
	function checkStartStream(){
		var checkbox = $("#startstreamcheckbox").is(":checked");
		if(!checkbox){
			alert('Please confirm the checkbox');
			return false;
		}else{
			$("#startstreamcheckbox").prop('checked', false);
			toggleStartStream();
			return true;
		}
	}
	function showBlock() {
		$("#showhistory").toggle(timeToHide);
	}
	function showHelp(){
		$("#help").toggle(timeToHide);
	}
	function startStream(){
		$("#startstream").toggle(timeToHide);
	}
	function hideError(){
		$("#error").toggle(timeToHide);
		}
	function hideSuccess(){
		$("#success").toggle(timeToHide);
		window.location.replace("http://foliage-bet.com/you");
	}
	function hideErrorMessage(){
		window.location.replace("you");
	}
	</script>
	<title><?php echo $_SESSION['channel'];?></title>
</head>
<body>
<div id="head">
	<table>
		<th>
			<a href="/"><img class="headimages" src="img/mainsite.png" href="index.html" title="Home"></img></a>
		</th>
		<th>
			<a onclick="startStream()"><img class="headimages" src="img/startstream.png" title="Start stream"></img></a>
		</th>
		<th>
			<a onclick="makeBet()"><img class="headimages" src="img/makeabet.png" title="New bet"></img></a>
		</th>
		<th>
			<a onclick="showBlock()"><img class="headimages" src="img/showhistory.png" title="Show history" ></img></a>
		</th>
		<th>
			<a><img class="headimages" src="img/buycoins.png" title="Buy fuel for bets" style="opacity:0.25"></img></a>
		</th>
		<th>
			<a><img class="headimages" src="img/sellcoins.png" title="Sell fuel" style="opacity:0.25"></img></a>
		</th>
		<th>
			<a onclick="showHelp()"><img class="headimages" src="img/help.png" title="Help"></img></a>
		</th>
		<th>
			<a href="logout"><img class="headimages" src="img/logout.png" title="Log out"></img></a>
		</th>
	</table>
</div>


<div id="menu">
<hr>
	<table id="menu_table">
		<tr>
			<th>Name: <span class="data"><?php echo $channel; ?></span>
			</th>
			<th>Balance: <span class="data"><?php echo $balance; ?></span>
			</th>
			<th>Count of bets: <span class="data"><?php echo $countofbets; ?></span>
			</th>
			<th>Win rate: <span class="data"><?php echo round($winrate, 2)."%";?></span>
			</th>
		</tr>
	</table>
</div>
<?php 
include_once "handlebet.php"; include_once "startstream.php";
?>

<div id="help">
	<div id="innerhelp">
		<h2 style="text-align: center">Help and FAQ</h2>
		<p>This is the platfom on which you kann bet for games of your gamer. It is pretty easy and fun. </br>
		<a class="bold">For Streamer:</a>The programm is 95% automatedm and all you have to do is just: 
			<li>Write into the Twitch chat <a class="command">bet start</a>. After 5 minutes Bets will be automated closed.</li>
			<li>After the game write into the chat <a class="command">game end</a> and <a class="positivebet">+</a> or <a class="negativebet">-</a> depending on the result.(<a class="positivebet">+</a> if you won, <a class="negativebet">-</a> if you lost).<br>
			<a style="font-style: italic">Example:</a> bet start, game end +</li>
		<a class="bold">For user:</a> After you loged in, you can press axe button for a new bet. Please make sure you already have got coins for bet. You can get it with the press of fuel case button and than choise your favorite payment method. Then write into the form all required information, confirm agreement checkbox and press Bet. After that you habe a possibility to get all info from the Twitch chat. There are the possible commands withinh the Twitch chat:
		<li>Write <a class="command">bet count</a> to get information how much coins already is in the game.</li>
		<li>Write <a class="command">am i dabei</a> to get information if your bet was successful accepted.</li>
	</div>
</div>
<form action="you" method="post" name="formMakeBet">
	<div id="make_bet">
	<!-- form to handle the make bet window: channelinput, whoinput and countinput -->
		<table id="bet_table">
			<tr>
				<th id="channellabel">channel</th>
				<th id="wholabel">result</th>
				<th id="countlabel">size</th>
			</tr>
			<tr>
				<th>
					<input type="text" id="channelinput" name="channelinputpost">
				</th>
				<th>
					<select id="whoinput" name="whoinput">
					 	<option>win</option>
						<option>loss</option>
					</select>
				</th>
				<th>
					<input type="number" id="countinput" name="countinput">
				</th>
			</tr>

		</table>
		<div id="agreement">
			<table>
				<tr>
					<th><p>I agree with all that shit and i will be not against this service.</p></th>

					<th><input type="checkbox" id="checkedagreement"></input></th>
				</tr>
			</table>
		</div>
		<div id="agreementbuttons">
			<table id="agreementbuttontable">
				<tr>
					<th>
						<button class="okButton" onclick="return checkMakeBet()">Bet</button>
					</th>
					<th>
						<a class="cancelButton" onclick="makeBet()">Cancel</a>
					</th>
				</tr>
			</table>
		</div>
	</div>
</form>
<div id="showhistory">
<div id="br"></div>
	<div id="historyhelp">
		<table id="historytable">
			<tr>
				<th class="history mainrow">Nr.</th>
				<th class="history mainrow">Date</th>
				<th class="history mainrow">Channel</th>
				<th class="history mainrow">Expect</th>
				<th class="history mainrow">Win</th>
			</tr>
			<?php 
				$i = 1;
				$query = 'select * from bets where uid = (select uid from user where channel ="'.$_SESSION['channel'].'")';
				$results = mysqli_query($connection, $query);
				while ($result=mysqli_fetch_assoc($results)) {
					$qu = 'select channel from user where uid=(select streamedBy from game where gid='.$result['gid'].')';
					$ch = mysqli_query($connection, $qu);
					$ro = mysqli_fetch_assoc($ch);
					$who = $ro['channel'];
					if($result['win']>0){
						$class = 'positivebet';
					}elseif ($result['win']<0){
						$class = 'negativebet';
					}else{
						$class = '';
					}
					echo '<tr>
							<th class="history">'.($i).'</th>
							<th class="history">'.$result['time'].'</th>
							<th class="history">'.$who.'</th>
							<th class="history">'.$result['expectation'].'</th>
							<th class="history '.$class.'">'.$result['win'].'</th>
						</tr>';
					$i++;
				}
			?>

		</table>
	</div>
</div>
<div id="startstream">
	<table>
		<tr>
			<th><p>I agree with all that shit and I want to start a stream.</p></th>
			<th><input type="checkbox" id="startstreamcheckbox" style="width:25px;height:25px"></input></th>
		</tr>
	</table>
	<p style="font-size:18px">After click on Start you will be given 20 minutes to let the users know about starting a bet (<a class="bold">command in the Twitch chat:</a> <a class="command">bet start</a>). <a style="color:rgb(50,149,226)">Otherwise the Program will be automated closed.</a></p>
	<div id="startstreambutton">
		
			<a href="you?start=true" class="okButton" onclick="return checkStartStream()">Start</a>
			<button id="temporary" class="cancelButton" onclick="toggleStartStream()">Cancel</a>

	</div>
</div>
</body>
</html>