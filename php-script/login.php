<?php
  require_once('adaptation.php');
  $con = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME); //connect to AWS RDS

  if (mysqli_connect_errno()) {
    echo "1: Connection failed"; //error code#1 = connection fail
    exit();
  }

  $username = mysqli_real_escape_string($con, $_POST["name"]);
  $usernameclean = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
  $password = $_POST["password"];
  //check if username exists
  $nameCheckQuery = "SELECT username, salt, hash, score FROM players WHERE username='".$usernameclean."';";
  $nameCheck = mysqli_query($con, $nameCheckQuery) or die("2: Name check query failed"); //error code#2 - username check query failed
  if (mysqli_num_rows($nameCheck) != 1) {
    echo "5: Either no user with name, or more than one"; //error code #5 - number of names matching != 1
    exit();
  }

  //get login into from query
  $existingInfo = mysqli_fetch_assoc($nameCheck);
  $salt = $existingInfo["salt"];
  $hash = $existingInfo["hash"];

  $loginhash = crypt($password, $salt);
  if ($hash != $loginhash) {
    echo "6: Incorrect password"; //error code #6 - password does not hash to match data from table
    exit();
  }

  echo "0|".$existingInfo["score"];

 ?>
