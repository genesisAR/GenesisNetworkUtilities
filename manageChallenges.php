<?php
if(isset($_POST['mode'])){
  include_once 'scripts/connect.php';
  $mode = mysqli_real_escape_string($mysqli, $_POST['mode']);
  if($mode == "0"){
    if(isset($_POST['challengeFrom']) && isset($_POST['challengeTo']) && isset($_POST['serverID'])){
      //ISSUE CHALLENGE
      $challengerUID = mysqli_real_escape_string($mysqli, $_POST['challengeFrom']);
      $challengedUID = mysqli_real_escape_string($mysqli, $_POST['challengeTo']);
      $serverID = mysqli_real_escape_string($mysqli, $_POST['serverID']);
      $insert_query = mysqli_query($mysqli, "INSERT INTO challenge_requests(challengeFrom, challengeTo, serverID, date_challenged)
                          VALUES('$challengerUID', '$challengedUID', '$serverID', now())") or die(mysqli_error($mysqli));
      if($insert_query){
        echo "0";
        exit();
      }
    }
  } else if($mode == "1"){
    if(isset($_POST['challengedUID'])){
      //GET CHALLENGES
      $challengedUID = mysqli_real_escape_string($mysqli, $_POST['challengedUID']);
      $sql = mysqli_query($mysqli, "SELECT * FROM challenge_requests WHERE challengeTo='$challengedUID' LIMIT 1") or die(mysqli_error($mysqli));
      $challenge_exists = mysqli_num_rows($sql);
      if($challenge_exists > 0){
        while($challengeData = mysqli_fetch_array($sql)){
          $serverID = $challengeData['serverID'];
          $challengerUID = $challengeData['challengeFrom']; //USE TO FIND CHALLENGER USERNAME
          $username_query = mysqli_query($mysqli, "SELECT username FROM accounts WHERE UID_string='$challengerUID' LIMIT 1") or die(mysqli_error($mysqli));
          $username_exists = mysqli_num_rows($username_query);
          if($username_exists > 0){
            while($usernameData = mysqli_fetch_array($username_query)){
              $challengerUsername = $usernameData['username'];
              echo $challengerUsername . "|" . $serverID;
              exit();
            }
          } else {
            //USER DOESN'T EXIST
            echo "0";
            exit();
          }
        }
      } else {
        //CHALLENGE DOESN'T EXIST
        echo "1";
        exit();
      }
    }
  } else if($mode == "2"){
    if(isset($_POST['serverID'])){
      //ACCEPT CHALLENGE
      $serverID = mysqli_real_escape_string($mysqli, $_POST['serverID']);
      $search_query = mysqli_query($mysqli, "SELECT * FROM challenge_requests WHERE serverID='$serverID' LIMIT 1") or die(mysqli_error($mysqli));
      $exists = mysqli_num_rows($search_query);
      if($exists > 0){
        $del_query = mysqli_query($mysqli, "DELETE FROM challenge_requests WHERE serverID='$serverID' LIMIT 1") or die(mysqli_error($mysqli));
        if($del_query){
          //SUCCESS
          echo "0";
          exit();
        } else {
          //CHALLENGE PENDING REMOVAL FAILED
          echo "1";
          exit();
        }
      } else {
        //CHALLENGE PENDING SERVERID DOES NOT EXIST
        echo "2";
        exit();
      }
    }
  }
}
?>
