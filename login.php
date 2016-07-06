<?php
if(isset($_POST['username']) && isset($_POST['password'])){
	include_once('scripts/connect.php');

	//RETURNS CHARACTER CHAR_IMAGE
	function returnCharacterIcon($CID) {
		global $mysqli;
		$CID_query = mysqli_query($mysqli, "SELECT image_path FROM creatures WHERE CID_string='$CID' LIMIT 1") or die(mysqli_error($mysqli));
		$CID_exists = mysqli_num_rows($CID_query);
		if($CID_exists > 0){
			while($CID_datafetch = mysqli_fetch_array($CID_query)){
				$image_path = $CID_datafetch['image_path'];
				return $image_path;
			}
		} else {
			return "osirus";
		}
	}



	// function checkForExpiry($) {
	//
	//
	// }

	function deleteFromOnline($UID) {
		global $mysqli;
		$deleteQuery = mysqli_query($mysqli, "DELETE FROM online_accounts WHERE UID_string='$UID' LIMIT 1") or die(mysqli_error($mysqli));
	}

	$username = mysqli_real_escape_string($mysqli, $_POST['username']);
	$password = mysqli_real_escape_string($mysqli, $_POST['password']);

	$sql = mysqli_query($mysqli, "SELECT * FROM accounts WHERE username='$username' AND password='$password'") or die(mysqli_error($mysqli));
	$exists = mysqli_num_rows($sql);
	if($exists > 0){
		while($row = mysqli_fetch_assoc($sql)){
			$UID_string = $row['UID_string'];
			$char_icon = $row['icon'];
			$trial_mode = $row['trial_mode'];
			$isOnline_query = mysqli_query($mysqli, "SELECT * FROM online_accounts WHERE UID_string='$UID_string' LIMIT 1") or die(mysqli_error($mysqli));
			$online_exists = mysqli_num_rows($isOnline_query);
			if($online_exists > 0){
				deleteFromOnline($UID_string);
			}
			$charIcon = returnCharacterIcon($char_icon);
			$JSONArray = array('UID_string' => $UID_string, 'char_icon' => $charIcon, 'trial_mode' => $trial_mode);
			echo json_encode($JSONArray);
			exit();
		}
	} else {
		echo "0";
		exit();
	}
}
?>
