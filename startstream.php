<?php 
	session_start();
	if($_GET['start']=='success'){
		echo '<div class="greenbackground">
				<div id="fogotit"></div>
				<div id="consuelatext">
					<a style="color:white;font-family:Courier New;font-size:40px;">Congratulations!<br>You has just created a new game!<br>Now you have 10 minutes to start a bet.<br>
					Use <span style="font-width:bold;color:yellow">bet start</span> in the Twitch chat</a><br><br>
					<button style="font-size:25px;color:white;background-color:transparent;border-radius:5px;padding: 8px 12px;margin-left:50%;" 
						onclick="hideErrorMessage()">Continue</button>
				</div>
			</div>';
			die();
	}

	if($_SESSION['channel']==null){
		header("Location: /");
	}else{
		if($_GET['start']==true){
			$connection = mysqli_connect('127.0.0.1', 'root', '', 'FOLIAGE_BET');
			$query = 'select count(streamedBy) from game where streamedBy=(select uid from user where channel = "'.$_SESSION['channel'].'") AND (result="unknown" OR result="started" OR result = "created")';
			$res = mysqli_query($connection, $query);
			$i = mysqli_fetch_assoc($res);
			if($i['count(streamedBy)']>0){
				echo '<div class="blackbackground">
				<div id="yougotit"></div>
				<div id="consuelatext">
					<a style="color:white;font-family:Courier New;font-size:40px;">...no, no!<br>You already have started a stream or the last stream was not finished!</a><br><br>
					<button style="font-size:25px;color:white;background-color:transparent;border-radius:5px;padding: 8px 12px;margin-left:50%;" 
						onclick="hideErrorMessage()">Back</button>
				</div>
			</div>';
			}else{
				$query = 'insert into game (streamedBy) values ((select uid from user where channel="'.$_SESSION['channel'].'"))';
				$result = mysqli_query($connection, $query);
				echo '<script type="text/javascript">new function(){document.location.replace("you?start=success");}</script>';
				exec("java -jar java/bin/Main.jar ".$_SESSION['channel']);
				ini_set('max_execution_time', 300);
				
			}
		}
	}
?>