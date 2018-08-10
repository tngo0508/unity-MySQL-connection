<?php
  require_once('adaptation.php');
  $con = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME); //connect to AWS RDS

  if (mysqli_connect_errno()) {
    echo "1: Connection failed"; //error code#1 = connection fail
    exit();
  }

  $username = $_POST["name"];
  $newScore = $_POST["score"];

  //double check there is only one user with this name
  $nameCheckQuery = "SELECT username FROM players WHERE username='".$username."';";

  $nameCheck = mysqli_query($con, $nameCheckQuery) or die("2: Name check query failed"); //error code#2 - username check query failed

  if (mysqli_num_rows($nameCheck) != 1) {
    echo "5: Either no user with name, or more than one"; //error code #5 - number of names matching != 1
    exit();
  }

  $updatequery = "UPDATE players SET score =".$newScore." WHERE username = '".$username."';";
  mysqli_query($con, $updatequery) or die("7: Save query failed"); //error code #7 - UPDATE query failed

  echo "0";

 ?>
