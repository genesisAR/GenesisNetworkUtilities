<?php
if(isset($_POST['UID']) && isset($_POST['UIDtoDel']) && isset($_POST['PENDING'])){
  include_once 'scripts/connect.php';
  $UID = mysqli_real_escape_string($mysqli, $_POST['UID']);
  $UIDtoDel = mysqli_real_escape_string($mysqli, $_POST['UIDtoDel']);

  $sql = mysqli_query($mysqli, "SELECT * FROM pending_friendreq WHERE UID_from='$UID' AND UID_to='$UIDtoDel' LIMIT 1") or die(mysqli_error($mysqli));
  $exists = mysqli_num_rows($sql);
  if($exists > 0){
    $del_query = mysqli_query($mysqli, "DELETE FROM pending_friendreq WHERE UID_from='$UID' AND UID_to='$UIDtoDel' LIMIT 1") or die(mysqli_error($mysqli));
    if($del_query){
      echo "0";
      exit();
    }
  } else {
    echo "Specified Friend Does Not Exist";
    exit();
  }

}
?>
