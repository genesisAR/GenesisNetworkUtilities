<?php 
// Host Name
$db_host = "localhost"; 
// SQL DB user
$db_username = "root";
// SQL DB pass  
$db_pass = "";  
// SQL connect DB Name
$db_name = "genesisLocalTests";
// Run the actual connection here  
$mysqli = mysqli_connect("$db_host","$db_username","$db_pass","$db_name") or die ("could not connect to mysqli");
?>
