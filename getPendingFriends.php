<?php
if(isset($_POST['UID']) && isset($_POST['mode'])){
  include_once 'scripts/connect.php';

  function fetchCIDIcon($CID) {
    global $mysqli;
    $sql = mysqli_query($mysqli, "SELECT image_path FROM creatures WHERE CID_string='$CID' LIMIT 1") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($sql);
    if($exists > 0){
      while($row = mysqli_fetch_array($sql)){
        $icon = $row['image_path'];
      }
      return $icon;
    }
  }

  $data_string = "";
  $UID_string = mysqli_real_escape_string($mysqli, $_POST['UID']);
  $mode = mysqli_real_escape_string($mysqli, $_POST['mode']);
  if($mode == "1"){
    $sql = mysqli_query($mysqli, "SELECT * FROM pending_friendreq WHERE UID_to='$UID_string' LIMIT 1") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($sql);
    if($exists > 0){
      while($row = mysqli_fetch_array($sql)){
        $UID_from = $row['UID_from'];
        $id_for_pharsing = $row['id'];
        $sql = mysqli_query($mysqli, "SELECT username FROM accounts WHERE UID_string='$UID_from' LIMIT 1");
        $exists = mysqli_num_rows($sql);
        if($exists > 0){
          while($row = mysqli_fetch_array($sql)){
            $username = $row['username'];
            $data_string = $id_for_pharsing . "|" . $username;
          }
        }
      }

      echo $data_string;
      exit();

    }
  } else if($mode == "2") {
    $pending_reqList = "";
    $sql = mysqli_query($mysqli, "SELECT * FROM pending_friendreq WHERE UID_from='$UID_string'") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($sql);
    if($exists > 0){
      while($row = mysqli_fetch_array($sql)){
        $UID_to = $row['UID_to'];
        $username_query = mysqli_query($mysqli, "SELECT * FROM accounts WHERE UID_string='$UID_to' LIMIT 1") or die(mysqli_error($mysqli));
        $username_exists = mysqli_num_rows($username_query);
        if($username_exists > 0){
          while($account_row = mysqli_fetch_array($username_query)){
             $username = $account_row['username'];
             $UID = $account_row['UID_string'];
             $icon_CID = $account_row['icon'];
             $icon_string = fetchCIDIcon($icon_CID);
             $pending_reqList .= $username . "|" . $UID . "|" . $icon_string . "~";
          }
        } else {
          echo "UID_TO get Failed";
          exit();
        }
      }
      echo $pending_reqList;
      exit();
    } else {
      echo "Account doesn't exist";
      exit();
    }
  } else {
    echo "UNDEFINED ERROR";
    exit();
  }
}
?>
