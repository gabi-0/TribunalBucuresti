<?php

include "session.php";

if(isset($_session_id)) {
	header('Location: /');
	exit();
}

$pageTitle = "Pagina inexistenta";

?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main class="container"><h1 class="display-1"><strong>404</strong></h1><h1 class="display-4">Nu am gasit pagina cautata</h1>
<br><h4><a href="javascript:history.back()">Revino inapoi</a></h4>
<h4><a href="/">Mergi acasa</a></h4>
</main>
</body></html>