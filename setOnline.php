<?php
// if(isset($_GET['UID_string'])){
  include_once 'scripts/connect.php';

  // function removeChallenges($UID_from) {
  //   global $mysqli;
  //   $sql = mysqli_query($mysqli, "SELECT * FROM challenge_requests WHERE challengeFrom='$UID_from'") or die(mysqli_error($mysqli));
  //   $exists = mysqli_num_rows($sql);
  //   if($exists > 0){
  //       $delete_query = mysqli_query($mysqli, "DELETE FROM challenge_requests WHERE challengeFrom='$UID_from'") or die(mysqli_error($mysqli));
  //   }
  // }
  //
  // $mode = mysqli_real_escape_string($mysqli, $_GET['mode']);
  // $UID_string = mysqli_real_escape_string($mysqli, $_GET['UID_string']);

  echo $_GET['mode'] . "  " . $_GET['UID_string'];
  exit();

  //MODE @ 0 = SET USER AS ONLINE
  if($mode == 0){
    $sql = mysqli_query($mysqli, "SELECT id FROM online_accounts WHERE UID_string='$UID_string' LIMIT 1");
    $exists = mysqli_num_rows($sql);
    if($exists == 0){
      $sql = mysqli_query($mysqli, "INSERT INTO online_accounts(UID_string) VALUES('$UID_string')") or die(mysqli_error($mysqli));
      echo "1";
      exit();
    }
  }
  //MODE @ 1 = REMOVE USER FROM ONLINE
  else if ($mode == 1){
    $sql = mysqli_query($mysqli, "DELETE FROM online_accounts WHERE UID_string='$UID_string'") or die(mysqli_error($mysqli));
    removeChallenges($UID_string);
    echo "1";
    exit();
  } else {
    echo "Exists";
    exit();
  }
// }
?>
