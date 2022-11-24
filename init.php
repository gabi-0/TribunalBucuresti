<?php

$_servername = "localhost";
$_username = "basic";
$_password = file_get_contents("p");
$_database = "proces_v.16";

$db = mysqli_connect($_servername, $_username, $_password, $_database);

if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}