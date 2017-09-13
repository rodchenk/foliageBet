<?php
	session_start();
	$connection = mysqli_connect('127.0.0.1', 'root', '', 'FOLIAGE_BET');

	$channel = $_SESSION['channel'];

	$query = 'select * from user where channel="'.$channel.'"';
	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	$balance = $row['balance'];

	$query = "select count(uid) from bets where uid = (select uid from user where channel = '$channel')";
	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	$countofbets = $row['count(uid)'];

	$query = "select count(uid) from bets where uid = (select uid from user where channel = '$channel') AND win>0";
	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	$countofwinbets = $row['count(uid)'];
	if($countofwinbets==0){
		$winrate=0;
	}else{
		$winrate = $countofwinbets/$countofbets*100;
	}
	
?>