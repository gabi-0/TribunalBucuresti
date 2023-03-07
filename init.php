<?php


if(!isset($db)) {

	$__servername = "localhost";
	$__username = "basic";
	$__password = file_get_contents("p");
	$__database = "proces_v.7";

	$db = mysqli_connect($__servername, $__username, $__password, $__database);

	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}
}