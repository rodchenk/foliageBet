<?php session_start();?>
<?php  
	if($_SESSION['auth']){
		$conn = mysqli_connect('127.0.0.1', 'root', '', 'FOLIAGE_BET');
		if(!$conn) echo "Error with connection to database";

		$token = $_GET['token'];
		$urltwitch = 'https://api.twitch.tv/kraken?oauth_token='.$token;

		function curl_get_contents($url){
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;		
		}
		$json = json_decode(curl_get_contents($urltwitch), true);
		$channel = $json['token']['user_name'];
		if($_SESSION['channel']==null){
			$_SESSION['channel']=$channel;

			$query = 'select count(uid) from user where channel = "'.$channel.'"';
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($result);
					
			if($row['count(uid)']==0){
				$query = 'insert into user (channel, token) values ("'.$channel.'","'.$token.'")';
				$result = mysqli_query($conn, $query);
			}else{
				$query = 'update user set token = "'.$token.'" where channel ="'.$channel.'"';
				$result = mysqli_query($conn, $query);
			}
		}
	}else{
		header("Location: /");
	}
?>