<?php
if(isset($_POST['username'])){
	include_once('scripts/connect.php');

	$username = mysqli_real_escape_string($mysqli, $_POST['username']);
	$UID = null;
	$characterArray = "";
	
	$sql = mysqli_query($mysqli, "SELECT UID_string FROM accounts WHERE username='$username' LIMIT 1") or die(mysqli_error($mysqli));
	$exists = mysqli_num_rows($sql);
	if($exists > 0){
		while($row = mysqli_fetch_array($sql)){
			$UID = $row['UID_string'];
		}
	} else {
		echo "0";
		exit();
	}
	
	if($UID != null){
		$sql = mysqli_query($mysqli, "SELECT CID_string FROM user_creatures WHERE UID_string='$UID' ORDER BY id DESC");
		$exists = mysqli_num_rows($sql);
		if($exists > 0){
			while($row = mysqli_fetch_array($sql)){
				$CID = $row['CID_string'];
				$characterArray .= $CID . "|";
			}
		}
	}
	
	if($characterArray != ""){
		echo $characterArray;
		exit();
	} else {
		echo "1";
		exit();
	}
}
?>