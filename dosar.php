<?php
$pageTitle = "Informatii dosar";

if(empty($_GET["id"])) {
	header('Location: /dosare.php');
	exit();
}

include "session.php";
include "init.php";

$id = mysqli_real_escape_string($db, htmlspecialchars($_GET['id']));


?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main>
<div style="display:block;height:4rem;"></div>



</main>
</body></html>