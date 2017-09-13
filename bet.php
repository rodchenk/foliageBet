<?php
	/*
	<target>all what we need to check</target>
	does a user authorized? +
	does the input channel exist in the table? +
	does a streamer have now stream and a bet is yet valid? +
	isn't user a streamer? +
	does a user have enough coins? +
	*/

	session_start();
	$connection = mysqli_connect('127.0.0.1', 'root', '', 'FOLIAGE_BET');
	if(!$_SESSION){
		header("Location: /")
	}else{
		$channel = $_POST["channelinputpost"];
		$count = $_POST["countinput"];
		$expectation = $_POST["whoinput"];

		$query = 'select count(streamedBy) from game where streamedBy = (select uid from user where channel = "'.$channel.'")';
		$result = mysqli_query($connection, $query);
		$row = mysqli_fetch_assoc($result);
		if($row['count(streamedBy']==0){
			$error = 'invaliduser';
		}else{
			$query = 'select count(streamedBy) from game where streamedBy = (select uid from user where channel = "'.$channel.'") AND result = "started"';
			$result = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($result);
			if($row['count(streamedBy)']==0){
				$error = 'betclosed';
			}else{
				$query = 'select count(streamedBy) from game where streamedBy = (select uid from user where channel = "'.$channel.'") AND result = "unknown"';
				$result = mysqli_query($connection, $query);
				$row = mysqli_fetch_assoc($result);
				if($row['cound(streamedBy']==0){
					$error 'betnotstarted';
				}else{
					if($channel==$_SESSION['channel']){
						$error = 'selfbet';
					}else{
						$query = 'select balance from user where channel = "'.$_SESSION['channel'].'"';
						$result = mysqli_query($connection, $query);
						$row = mysqli_fetch_assoc($result);
						if($row['balance']<$count){
							$error = 'littlecash';
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
						}
					}
				}
			}
		}
	}
?>