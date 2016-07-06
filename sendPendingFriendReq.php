<?php
if(isset($_POST['from']) && isset($_POST['to'])){
  require_once 'scripts/connect.php';

  $from_user = mysqli_real_escape_string($mysqli, $_POST['from']);
  $to_user = mysqli_real_escape_string($mysqli, $_POST['to']);

  $sql = mysqli_query($mysqli, "SELECT UID_string FROM accounts WHERE UID_string='$to_user' LIMIT 1") or die(mysqli_error($mysqli));
  $exists = mysqli_num_rows($sql);
  if($exists > 0){
    while($row = mysqli_fetch_array($sql)){
      $toUID = $row['UID_string'];
      $sql = mysqli_query($mysqli, "SELECT * FROM pending_friendreq WHERE UID_from='$from_user' AND UID_to='$toUID' LIMIT 1") or die(mysqli_error($mysqli));
      $exists = mysqli_num_rows($sql);
      if($exists == 0){
        $sql = mysqli_query($mysqli, "INSERT INTO pending_friendreq(UID_from, UID_to, date_added)
                            VALUES('$from_user', '$toUID', now())") or die(mysqli_error($mysqli));
      }
    }
  } 
}

if(isset($_POST['from']) && isset($_POST['toUID'])){
  require_once 'scripts/connect.php';

  $from_user = mysqli_real_escape_string($mysqli, $_POST['from']);
  $to_user = mysqli_real_escape_string($mysqli, $_POST['toUID']);

  $sql = mysqli_query($mysqli, "SELECT * FROM pending_friendreq WHERE UID_from='$from_user' AND UID_to='$to_user' LIMIT 1") or die(mysqli_error($mysqli));
  $exists = mysqli_num_rows($sql);
  if($exists == 0){
    $sql = mysqli_query($mysqli, "INSERT INTO pending_friendreq(UID_from, UID_to, date_added)
                        VALUES('$from_user', '$to_user', now())") or die(mysqli_error($mysqli));
  }

}
?>
