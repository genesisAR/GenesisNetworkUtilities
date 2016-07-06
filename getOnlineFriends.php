<?php
if(isset($_POST['friends'])){
  include_once 'scripts/connect.php';
  $friendList = mysqli_real_escape_string($mysqli, $_POST['friends']);
  $friendArray = explode("~", $friendList);
  $supplementaryString = "";

  foreach ($friendArray as $friend) {
    $friendData = explode("|", $friend);
    $friendUID = $friendData[0];
    $sql = mysqli_query($mysqli, "SELECT * FROM online_accounts WHERE UID_string='$friendUID' LIMIT 1") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($sql);
    if($exists > 0){
      $supplementaryString .= "1|";
    } else {
      $supplementaryString .= "0|";
    }
  }
  echo $supplementaryString;
  exit();
}
?>
