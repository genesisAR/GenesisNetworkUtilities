<?php
if(isset($_POST['UID'])){
  include_once 'scripts/connect.php';
  $UID_string = mysqli_real_escape_string($mysqli, $_POST['UID']);
  $sql =  mysqli_query($mysqli, "DELETE FROM online_accounts WHERE UID_string = '$UID_string' LIMIT 1") or die(mysqli_error($mysqli));
  if($sql){
    echo "0";
  } else {
    echo "1";
  }
  exit();
}
?>
