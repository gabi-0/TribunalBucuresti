<?php

$pageTitle = "Tribunalul BUCURESTI";

include "session.php";
include "init.php";

$q = "SELECT * FROM Magistrati;";
mysqli_query($db, $q);
exit();


?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main><div class="container"><form method="get" action="/dosare.php">
<div style="display:block;height:4rem;"></div>

<div class="input-group" style="width:50%;margin:auto">
<input name="numep" type="search" class="form-control rounded" placeholder="Cauta o persoana" aria-label="Search" aria-describedby="search-addon" />
<button type="button" class="btn btn-outline-primary">search</button></div>


</form></div></main>
</body></html>