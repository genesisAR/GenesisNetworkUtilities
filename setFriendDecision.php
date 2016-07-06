<?php
if(isset($_POST['requestID']) && isset($_POST['mode'])){
  include_once 'scripts/connect.php';
  $ID_to_pharse = mysqli_real_escape_string($mysqli, $_POST['requestID']);
  $mode = mysqli_real_escape_string($mysqli, $_POST['mode']);
  if($mode == "true"){
    $sql = mysqli_query($mysqli, "SELECT * FROM pending_friendreq WHERE id='$ID_to_pharse' LIMIT 1") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($sql);
    if($exists > 0){
      while($row = mysqli_fetch_array($sql)){
        $UID_sender = $row['UID_from'];
        $UID_reciever = $row['UID_to'];

        $sql = mysqli_query($mysqli, "SELECT username FROM accounts WHERE UID_string='$UID_reciever' LIMIT 1") or die(mysqli_error($mysqli));
        $exists = mysqli_num_rows($sql);
        if($exists > 0){
          while($row = mysqli_fetch_array($sql)){
            $recieverUsername = $row['username'];

            $insert_sql = mysqli_query($mysqli, "INSERT INTO friends(friendUID, friendName, friendTo, date_added)
                                VALUES('$UID_reciever','$recieverUsername','$UID_sender',now())") or die(mysqli_error($mysqli));

            $username_query = mysqli_query($mysqli ,"SELECT username,UID_string FROM accounts WHERE UID_string='$UID_sender' LIMIT 1") or die(mysqli_error($mysqli));
            $username_exists = mysqli_num_rows($username_query);
            if($username_exists > 0){
              while($username_return = mysqli_fetch_array($username_query)){
                $username = $username_return['username'];
                $UID = $username_return['UID_string'];
                $coinsert_query = mysqli_query($mysqli, "INSERT INTO friends(friendUID, friendName, friendTo, date_added)
                                    VALUES('$UID_sender','$username','$UID_reciever',now())") or die(mysqli_error($mysqli));
              }
            }

            if($insert_sql){
              $deleteQuery = mysqli_query($mysqli, "DELETE FROM pending_friendreq WHERE id='$ID_to_pharse' LIMIT 1") or die(mysqli_error($mysqli));
              echo $UID . "|" . $username;
              exit();
            } else {
              echo "sql insertation failed";
              exit();
            }

          }
        } else { echo "No such account user"; exit(); }

      }
    } else { echo "No such pending request"; exit(); }
  } else if ($mode == "false"){
    $deleteQuery = mysqli_query($mysqli, "DELETE FROM pending_friendreq WHERE id='$ID_to_pharse' LIMIT 1") or die(mysqli_error($mysqli));
    echo "DELETED FROM PENDING REQS";
    exit();
  } else {
    echo "FAILED TO EXECUTE DECISION BASED QUERY";
    exit();
  }
} else {
  echo "NAH";
  exit();
}
?>
