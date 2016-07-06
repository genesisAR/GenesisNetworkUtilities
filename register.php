<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function checkForExistingUsername($USER) {
    global $mysqli;
    $sql = mysqli_query($mysqli, "SELECT * FROM accounts WHERE username='$USER' LIMIT 1");
    $exists = mysqli_num_rows($sql);
    if($exists == 0){
      return FALSE;
    } else {
      return TRUE;
    }
}
?>
<?php
if(isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])){
	include_once('scripts/connect.php');
	$UID = generateRandomString();
  $email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$username = mysqli_real_escape_string($mysqli, $_POST['username']);

  if(checkForExistingUsername($username) == TRUE){
    echo "1";
    exit();
  }

	$password = mysqli_real_escape_string($mysqli, $_POST['password']);

	$sql = mysqli_query($mysqli, "INSERT INTO accounts(UID_string, email, username, password, date_added)
		VALUES('$UID','$email','$username','$password', now())") or die(mysqli_error($mysqli));

  if($sql){
    echo "0";
    exit();
  }
}
?>
