<?php
if(isset($_POST['secret']) && isset($_POST['mode'])){
  include_once 'scripts/connect.php';

  function insertWinner($winner) {
    global $mysqli;
    $insert_query = mysqli_query($mysqli, "INSERT INTO tvcDB(winner, date_won)
                    VALUES('$winner', now())") or die(mysqli_error($mysqli));
    if($insert_query){
      return "0";
    } else {
      return "1";
    }
  }

  function fetchTrump(){
    global $mysqli;
    $donald_query = mysqli_query($mysqli, "SELECT * FROM tvcDB WHERE winner='Donald'") or die(mysqli_error($mysqli));
    $donaldCount = mysqli_num_rows($donald_query);
    return $donaldCount;
  }

  function fetchHillary() {
    global $mysqli;
    $hillary_query = mysqli_query($mysqli, "SELECT * FROM tvcDB WHERE winner='Hillary'") or die(mysqli_error($mysqli));
    $hillaryCount = mysqli_num_rows($hillary_query);
    return $hillaryCount;
  }

  function returnTotals() {
    return fetchTrump() . "|" . fetchHillary();
  }

  $secret = mysqli_real_escape_string($mysqli, $_POST['secret']);
  $mode = mysqli_real_escape_string($mysqli, $_POST['mode']);
  if($secret == "9Oq64iagJDtWBdVFaMRg"){
    if($mode == "0"){
      //FETCH COUNT DATA
      echo returnTotals();
      exit();
    } else if($mode == "1"){
      //INSERT DATA
      if(isset($_POST['winner'])){
        $winnerToInsert = mysqli_real_escape_string($mysqli, $_POST['winner']);
        if(insertWinner($winnerToInsert) == "0"){
          //QUERY INSERTED SUCCCESSFULLY
          returnTotals();
          exit();
        } else {
          echo "FAILED TO INSERT";
          exit();
        }
      }
    }
  }
}
?>
