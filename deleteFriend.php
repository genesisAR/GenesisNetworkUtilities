<?php
if(isset($_POST['UIDtoDel']) && isset($_POST['UID'])){
  include_once 'scripts/connect.php';
  $UID = mysqli_real_escape_string($mysqli, $_POST['UID']);
  $UIDtoDel = mysqli_real_escape_string($mysqli, $_POST['UIDtoDel']);
  $sql = mysqli_query($mysqli, "SELECT * FROM friends WHERE friendUID='$UIDtoDel' AND friendTo='$UID' LIMIT 1") or die(mysqli_error($mysqli));
  $exists = mysqli_num_rows($sql);
  if($exists > 0){
    $del_query = mysqli_query($mysqli, "DELETE FROM friends WHERE friendUID='$UIDtoDel' AND friendTo='$UID' LIMIT 1") or die(mysqli_error($mysqli));
    $alternatesql = mysqli_query($mysqli, "SELECT * FROM friends WHERE friendUID='$UID' AND friendTo='$UIDtoDel' LIMIT 1") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($alternatesql);
    if($exists > 0){
      $alternate_delquery = mysqli_query($mysqli, "DELETE FROM friends WHERE friendUID='$UID' AND friendTo='$UIDtoDel' LIMIT 1") or die(mysqli_error($mysqli));
    } else {
      echo "No corresponsing friend UID";
      exit();
    }

    if($del_query && $alternate_delquery){
      echo "0";
      exit();
    }
  } else {
    echo "Specified Friend Does Not Exist";
    exit();
  }
}
?>
