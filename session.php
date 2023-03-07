<?php


if(isset($_session_id))
	goto skip_load;


$clearCookie = false;


if(!isset($_COOKIE['sid']) || !isset($_COOKIE['stoken'])) {
	$clearCookie = true;
	goto skip_load;
}


include "init.php";

$sid = mysqli_real_escape_string($db, htmlspecialchars($_COOKIE["sid"]));
$token = mysqli_real_escape_string($db, htmlspecialchars($_COOKIE["stoken"]));

$query = "SELECT * FROM Sesiune WHERE id=". $sid .";";

if(($__res = mysqli_query($db, $query)) === false)
	goto skip_load;

if(mysqli_num_rows($__res) == 0) {
	$clearCookie = true;
	goto skip_load;
}

$__row = mysqli_fetch_assoc($__res);
if (empty($__row["expires"]) || empty($__row["token"])) {
	$clearCookie = true;
	goto skip_load;
}

// check expiration and check token
if($__row["expires"] < time() || hash_equals($__row["token"], $token) == false) {
	$clearCookie = true;
	goto skip_load;	
}


// load data
$_session_id = $_session_nume = $_session_prenume = $_session_email = null;
$_session_idReprezentant = $_session_idMagistrat = null;
$_session_isJudge = false;
if($__row["userR"])
	$_session_idReprezentant = $__row["userR"];
else {
	$_session_isJudge = true;
	$_session_idMagistrat = $__row["userM"];
}

if($__row["extend"] == 1) {
	$expires = time() + 60*60*24;
	setcookie("sid", $sid, $expires, '/', '', true, true);
	setcookie("stoken", $token, $expires, '/', '', true, true);
	$q = "UPDATE Sesiune SET expires='". $expires ."' WHERE id='". $sid ."';";
	mysqli_query($db, $q);
}


$query = "SELECT * FROM Reprezentanti WHERE id=". $_session_idReprezentant .";";
if($_session_isJudge)
	$query = "SELECT * FROM Magistrati WHERE id=". $_session_idMagistrat .";";

if(($__res = mysqli_query($db, $query)) === false || mysqli_num_rows($__res) == 0) {
	$clearCookie = true;
	goto skip_load;
}

$__row = mysqli_fetch_assoc($__res);
$_session_id = $__row["id"];
$_session_nume = $__row["nume"];
$_session_prenume = $__row["prenume"];
$_session_email = $__row["email"];


skip_load:

if($clearCookie) {
	setcookie("sid", "", 99);
	setcookie("stoken", "", 99);
	if(isset($db) && isset($sid))
		mysqli_query($db, "DELETE FROM Sesiune WHERE id=". $sid .";");
}