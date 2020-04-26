<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "fantacanottaggio";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (mysqli_connect_errno()){
  die("Connection failed: ".mysqli_connect_error());
}
