<?php
include_once('scripts/connect.php');

$sql = mysqli_query($mysqli, "SELECT * FROM creatures ORDER BY id DESC");
$characterArray = "";
$exists = mysqli_num_rows($sql);
if($exists > 0){
	while($row = mysqli_fetch_array($sql)){
		$CID = $row['CID_string'];
		$primary_name = $row['Primary_name'];
		$secondary_name = $row['Secondary_name'];
		$image_path = $row['image_path'];
		$characterArray .= $CID . "|" . $primary_name . "|" . $secondary_name . "|" . $image_path . "!";
	}
}

if($characterArray != ""){
	echo $characterArray;
	exit();
} else {
	echo "0";
	exit();
}

	
?>