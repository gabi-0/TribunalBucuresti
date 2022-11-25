<?php


if(isset($_session_id))
	goto no_session;


$clearCookie = false;


if(!isset($_COOKIE['sid']) || !isset($_COOKIE['stoken'])) {
	$clearCookie = true;
	goto no_session;
}


include "init.php";

$sid = mysqli_real_escape_string($db, htmlspecialchars($_COOKIE["sid"]));
$token = mysqli_real_escape_string($db, htmlspecialchars($_COOKIE["stoken"]));

$query = "SELECT * FROM Sesiune WHERE id=". $sid .";";

if(($res = mysqli_query($db, $query)) === false)
	goto no_session;

if(mysqli_num_rows($res) == 0) {
	$clearCookie = true;
	goto no_session;
}

$row = mysqli_fetch_assoc($res);
if (empty($row["expires"]) || empty($row["token"])) {
	$clearCookie = true;
	goto no_session;
}

// check expiration and check token
if($row["expires"] < time() || hash_equals($row["token"], $token) == false) {
	$clearCookie = true;
	goto no_session;	
}


// load data
$_session_id = $_session_nume = $_session_prenume = $_session_email = null;
$_session_idReprezentant = $_session_idMagistrat = null;
$_session_isJudge = false;
if($row["userR"])
	$_session_idReprezentant = $row["userR"];
else {
	$_session_isJudge = true;
	$_session_idMagistrat = $row["userM"];
}


$query = "SELECT * FROM Reprezentanti WHERE id=". $_session_idReprezentant .";";
if($_session_isJudge)
	$query = "SELECT * FROM Magistrati WHERE id=". $_session_idMagistrat .";";

if(($res = mysqli_query($db, $query)) === false || mysqli_num_rows($res) == 0) {
	$clearCookie = true;
	goto no_session;
}

$row = mysqli_fetch_assoc($res);
$_session_id = $row["id"];
$_session_nume = $row["nume"];
$_session_prenume = $row["prenume"];
$_session_email = $row["email"];


no_session:

if($clearCookie) {
	setcookie("sid", "", 99);
	setcookie("stoken", "", 99);
	if(isset($db) && isset($sid))
		mysqli_query($db, "DELETE FROM Sesiune WHERE id=". $sid .";");
}