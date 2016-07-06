<?php
if(isset($_POST['friendUsername']) && isset($_POST['UID_string'])){
    include_once 'scripts/connect.php';
    $friendUsername = mysqli_real_escape_string($mysqli, $_POST['friendUsername']);
    $UID_string = mysqli_real_escape_string($mysqli, $_POST['UID_string']);
    $potentialFriendList = "";
    $potentialFriendLength = 0;
    $sql = mysqli_query($mysqli, "SELECT * FROM accounts WHERE username='$friendUsername' LIMIT 1") or die(mysqli_error($mysqli));
    $exists = mysqli_num_rows($sql);
    if($exists > 0){
      while($row = mysqli_fetch_array($sql)){
        $friendUID = $row['UID_string'];
        $friendUser = $row['username'];
        // $sql = mysqli_query($mysqli, "INSERT INTO friends(friendUID, friendName, friendTo, date_added)
        //                     VALUES('$friendUID','$friendUser','$UID_string', now())") or die(mysqli_error($mysqli));
        $sql = mysqli_query($mysqli, "INSERT INTO pending_friendreq(UID_from, UID_to, date_added)
                            VALUES('$UID_string','$friendUID', now())") or die(mysqli_error($mysqli));
        echo "<!>".$friendUID;
        exit();
      }
    } else {
      //DOESNT EXIST SO PROVIDE RECOMMENDED FRIENDS
      $sql = mysqli_query($mysqli, "SELECT * FROM accounts WHERE UID_string!='$UID_string'");
      $exists = mysqli_num_rows($sql);
      if($exists > 0){
        while($row = mysqli_fetch_array($sql)){
            $actualUser = $row['username'];
            similar_text($friendUsername, $actualUser, $percent);
            if($percent >= 80 && $potentialFriendLength < 4){
              $potentialFriendLength += 1;
              $potentialUID = $row['UID_string'];
              $potentialFriendList .= $actualUser . "|" . $potentialUID . "~";
            }
        }

        echo $potentialFriendList;
        exit();

      }
    }
}

if(isset($_POST['friendUID']) && isset($_POST['UID_string'])){
  include_once 'scripts/connect.php';
  $friendUID = mysqli_real_escape_string($mysqli, $_POST['friendUID']);
  $UID_string = mysqli_real_escape_string($mysqli, $_POST['UID_string']);
  $sql = mysqli_query($mysqli, "SELECT * FROM accounts WHERE UID_string='$friendUID' LIMIT 1") or die(mysqli_error($mysqli));
  $exists = mysqli_num_rows($sql);
  if($exists > 0){
    while($row = mysqli_fetch_array($sql)){
      $friendUsername = $row['username'];
      // $sql = mysqli_query($mysqli, "INSERT INTO friends(friendUID, friendName, friendTo, date_added)
      //                     VALUES('$friendUID','$friendName','$UID_string',now())") or die(mysqli_error($mysqli));
      $sql = mysqli_query($mysqli, "INSERT INTO pending_friendreq(UID_from, UID_to, date_added)
                          VALUES('$UID_string','$friendUID', now())") or die(mysqli_error($mysqli));
      echo "<!>".$friendUID;
      exit();
    }
  } else {
    echo "No Suggestions";
    exit();
  }
}

?>
