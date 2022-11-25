<?php

include "session.php";

if(isset($_session_id)) {
	header('Location: /');
	exit();
}

$pageTitle = "Resetare parola";

?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main class="container">

<form method="post">
	<div class="form-group">
	<label for="inputUser">User</label>
	<input type="User" class="form-control" id="inputUser" placeholder="Enter User">
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

</main>
</body></html>