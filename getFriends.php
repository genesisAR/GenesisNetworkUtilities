<?php
if(isset($_POST['UID_string'])){
  include_once 'scripts/connect.php';

  function getCreatureIcon($CID){
    global $mysqli;
    $sql = mysqli_query($mysqli, "SELECT image_path FROM creatures WHERE CID_string='$CID' LIMIT 1") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($sql);
    if($exists > 0){
      while($row = mysqli_fetch_array($sql)){
        $image_path = $row['image_path'];
        return $image_path;
      }
    }
  }

  function getFriendIcon($friendUID) {
    global $mysqli;
    $icon_query = mysqli_query($mysqli, "SELECT * FROM accounts WHERE UID_string='$friendUID' LIMIT 1") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($icon_query);
    if($exists > 0){
      while($row = mysqli_fetch_array($icon_query)){
        $iconCID = $row['icon'];
        $char_parse = getCreatureIcon($iconCID);
      }
      return $char_parse;
    }
  }

  $UID_string = mysqli_real_escape_string($mysqli, $_POST['UID_string']);
  $friendResponse = "";
  $sql = mysqli_query($mysqli, "SELECT * FROM friends WHERE friendTo='$UID_string'");
  $exists = mysqli_num_rows($sql);
  if($exists > 0){
    while($row = mysqli_fetch_array($sql)){
      $friendUID = $row['friendUID'];
      $friendName = $row['friendName'];
      $friendIcon = getFriendIcon($friendUID);
      $friendResponse .= $friendUID . "|" . $friendName . "|" . $friendIcon . "~";
    }

    echo $friendResponse;
    exit();

  } else {
    echo "1";
    exit();
  }
}
?>
