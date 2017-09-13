<?php
	/*
	<target>all what we need to check</target>
	is a user authorized? +
	does the input channel exist in the table? +
	does a streamer has now stream and is a bet valid yet? +
	isn't user a streamer? +
	does a user has enough coins? +
	*/

	session_start();
	if($_GET['ok']==true){
		echo '<div class="greenbackground">
				<div id="fogotit"></div>
				<div id="consuelatext">
					<a style="color:white;font-family:Courier New;font-size:40px;">Congratulations!<br>You made a good bet. Enjoy the game!</a><br><br>
					<button style="font-size:25px;color:white;background-color:transparent;border-radius:5px;padding: 8px 12px;margin-left:50%;" 
						onclick="hideErrorMessage()">Continue</button>
				</div>
			</div>';
	}
	function get_error_message($type){
		return '<div class="blackbackground">
				<div id="yougotit"></div>
				<div id="consuelatext">
					<a style="color:white;font-family:Courier New;font-size:40px;">...no, no!<br>'.$type.'!</a><br><br>
					<button style="font-size:25px;color:white;background-color:transparent;border-radius:5px;padding: 8px 12px;margin-left:50%;" 
						onclick="hideErrorMessage()">Back</button>
				</div>
			</div>';
	}
	$connection = mysqli_connect('127.0.0.1', 'root', '', 'FOLIAGE_BET');
	if($_POST['channelinputpost']!=null){
		if(!$_SESSION){
			header("Location: /");
		}else{
			$channel = $_POST["channelinputpost"];
			$count = $_POST["countinput"];
			$expectation = $_POST["whoinput"];

			$query = 'select count(streamedBy) from game where streamedBy = (select uid from user where channel = "'.$channel.'")';
			$result = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($result);
			if($row['count(streamedBy)']==0){
				$error = 'There is no such streamer like '.$channel;
				echo get_error_message($error);
			}else{
				$query = 'select count(streamedBy) from game where streamedBy = (select uid from user where channel = "'.$channel.'") AND result = "started"';
				$result = mysqli_query($connection, $query);
				$row = mysqli_fetch_assoc($result);
				if($row['count(streamedBy)']==1){
					$error = 'Bet already is closed';
					echo get_error_message($error);
				}else{
					$query = 'select count(streamedBy) from game where streamedBy = (select uid from user where channel = "'.$channel.'") AND result = "created"';
					$result = mysqli_query($connection, $query);
					$row = mysqli_fetch_assoc($result);
					if($row['count(streamedBy)']==1){
						$error = 'Bet is closed yet, but will be opened soon';
						echo get_error_message($error);
					}else{
						$query = 'select count(streamedBy) from game where streamedBy = (select uid from user where channel = "'.$channel.'") AND result = "unknown"';
						$result = mysqli_query($connection, $query);
						$row = mysqli_fetch_assoc($result);
						if($row['count(streamedBy)']==0){
							$error = 'Bet is not started yet';
							echo get_error_message($error);
						}else{
							if($channel==$_SESSION['channel']){
								$error = 'Noway. You cant bet for yourself';
								echo get_error_message($error);
							}else{
								$query = 'select balance from user where channel = "'.$_SESSION['channel'].'"';
								$result = mysqli_query($connection, $query);
								$row = mysqli_fetch_assoc($result);
								if($row['balance']<$count){
									$error = 'Sir, you do not have enough money';
									echo get_error_message($error);
								}else{
									$query = 'select count(uid) from bets where uid = (select uid from user where channel = "'.$_SESSION['channel'].'") AND gid = (select gid from game where streamedBy = (select uid from user where channel = "'.$channel.'") AND result = "unknown")';
									$result = mysqli_query($connection, $query);
									$row = mysqli_fetch_assoc($result);
									if($row['count(uid)']==1){
										$error = 'You are allowed to make only one bet per game';
										echo get_error_message($error);
									}else{
										$query = 'insert into bets (uid, gid, count, expectation) values 
										((select uid from user where channel="'.$_SESSION['channel'].'"), 
										(select gid from game where streamedBy = (select uid from user where 
										channel = "'.$channel.'") AND result = "unknown"),'.$count.', "'.$expectation.'" );';
										$result = mysqli_query($connection, $query);
										
										$query = 'update user set balance = balance-'.$count.' where channel = "'.$_SESSION['channel'].'"';
										$result = mysqli_query($connection, $query);
										
										$query = 'update game set total = total+'.$count.' where result = "unknown" AND streamedBy = (select uid from user where channel = "'.$channel.'")';
										$result = mysqli_query($connection, $query);

										$query = 'update user set balance = balance+'.$count.' where channel = "foliage_bot"';
										$result = mysqli_query($connection, $query);
										
										echo '<script type="text/javascript">
										new function(){
											document.location.replace("you?ok=true");
										}
										</script>';
									}
								}
							}
						}
					}
				}
			}
		}
	}
?>