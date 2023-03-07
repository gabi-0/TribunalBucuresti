<?php


include "session.php";



if(!isset($_session_id)) {
	header('Location: /');
	exit();
}

setcookie("sid", "", 99);
setcookie("stoken", "", 99);
mysqli_query($db, "DELETE FROM Sesiune WHERE id=". $sid .";");

header('Location: /');
exit();