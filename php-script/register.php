<?php
    // $con = mysqli_connect('localhost', 'root', '', 'unityaccess');
  require_once('adaptation.php');
  $con = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME); //connect to AWS RDS


    if (mysqli_connect_errno()) {
      echo "1: Connection failed"; //error code#1 = connection fail
      exit();
    }

    $username = $_POST["name"];
    $password = $_POST["password"];

    //check if username exists
    $nameCheckQuery = "SELECT username FROM players WHERE username='".$username."';";
    $nameCheck = mysqli_query($con, $nameCheckQuery) or die("2: Name check query failed"); //error code#2 - username check query failed

    if (mysqli_num_rows($nameCheck) > 0) {
      echo "3: Name already exists"; //error code #3 - username exists cannot register
      exit();
    }

    //add user to the table
    $salt = "\$5\$rounds=5000\$"."steamedhams".$username."\$";
    $hash = crypt($password, $salt);
    $insertuserquery = "INSERT INTO players(username, hash, salt) VALUES ('".$username."', '".$hash."', '".$salt."');";
    mysqli_query($con, $insertuserquery) or die("4: Insert query failed"); //error code#4 - insert query failed

    echo ("0");
?>
