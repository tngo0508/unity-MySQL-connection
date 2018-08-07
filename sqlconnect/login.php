<?php
$con = mysqli_connect('localhost', 'root', '', 'unityaccess');

  if (mysqli_connect_errno()) {
    echo "1: Connection failed"; //error code#1 = connection fail
    exit();
  }

  $username = $_POST["name"];
  $password = $_POST["password"];
  //check if username exists
$nameCheckQuery = "SELECT username, salt, hash, score FROM players WHERE username='".$username."';";
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
