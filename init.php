<?php


if(!isset($db)) {

	$__servername = file_get_contents("sv.hid");
	$__username = file_get_contents("u.hid");
	$__password = file_get_contents("p.hid");
	$__database = file_get_contents("f.hid");
	//$__database = "proces_v.7";

	$db = mysqli_connect($__servername, $__username, $__password, $__database);

	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}
}