<?php
if(isset($_POST['icon_CID']) && isset($_POST['UID'])){
  include_once 'scripts/connect.php';

  function getCharacterIconFromCID($CID) {
    global $mysqli;
    $query = mysqli_query($mysqli, "SELECT CID_string FROM creatures WHERE CID_string='$CID' LIMIT 1") or die(mysqli_error($mysqli));
    $CID_exists = mysqli_num_rows($query);
    if($CID_exists > 0){
      while($row = mysqli_fetch_array($query)){
        $char_icon = $row['CID_string'];
        return $char_icon;
      }
    } else {
      return null;
    }
  }

  $icon_CID = mysqli_real_escape_string($mysqli, $_POST['icon_CID']);
  $UID_string = mysqli_real_escape_string($mysqli, $_POST['UID']);
  $icon = getCharacterIconFromCID($icon_CID);

  if($icon != null){
    $sql = mysqli_query($mysqli, "UPDATE accounts SET icon='$icon' WHERE UID_string='$UID_string' LIMIT 1") or die(mysqli_error($mysqli));
    if($sql){
      echo "0";
      exit();
    } else {
      echo "ERROR";
      exit();
    }
  } else {
    echo "ERROR NO SUCH CID";
    exit();
  }
}
?>
