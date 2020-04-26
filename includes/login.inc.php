<?php

if (isset($_POST['login-submit'])){
  require 'dbh.inc.php';
  require 'readWeb.inc.php';

  $username = $_POST['uid'];
  $password = $_POST['pwd'];

  if (empty($username) || empty($password)){
    header("Location: ../login.php?error=emptyfields&uid=".$username);
    exit();
  }
  $sql = "SELECT * FROM users WHERE uidUsers=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../login.php?error=sqlerrorselect");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($result)){
    $pwdCheck = password_verify($password, $row['pwdUsers']);
    if ($pwdCheck == false){
      header("Location: ../login.php?error=wrongpassword&uid=".$username);
      exit();
    } else if ($pwdCheck == true){
      session_start();
      $_SESSION['username'] = $row['uidUsers'];
      $file = fopen("../data/text/entra.txt", "a");
      fprintf($file, "%s %s\n", getData(), $_SESSION['username']);
      fclose($file);
      header("Location: ../index.php?login=success");
      exit();
    } else{
      header("Location: ../login.php?error=password&uid=".$username);
      exit();
    }
  } else{
    header("Location: ../login.php?error=nouser&uid=".$username);
    exit();
  }
} else{
  header("Location: ../index.php");
  exit();
}
