<?php

include "session.php";

if(isset($_session_id)) {
	header('Location: /');
	exit();
}

$set_new = false;

if ($_SERVER["REQUEST_METHOD"] != "POST")
	goto render_page;
if(empty($_POST["user"]) && (empty($_POST["pass"]) || empty($_POST["passc"]) || empty($_POST["token"])))
	goto render_page;



$q = "";


render_page:

$pageTitle = "Resetare parola";

?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main><div class="container">

<form method="post">
	<div style="display:block;height:6rem;"></div>
	<div class="col-md-4"><label for="inputUser">User</label>
	<input type="text" name="user" class="form-control" id="inputUser" placeholder="Type the username" required></div><br>
	<?php if($set_new) { ?>
	<div class="col-md-4"><label for="inputPass">Password</label>
	<input type="password" name="pass" class="form-control" id="inputPass" placeholder="Enter a new password" required></div><br>
	<div class="col-md-4"><label for="inputPassC">Confirm password</label>
	<input type="password" name="passC" class="form-control" id="inputPassC" placeholder="Re-type your password" required></div><br>
	<div class="col-md-4"><label for="inputToken">Token</label>
	<input type="text" name="token" class="form-control" id="inputToken" placeholder="Enter security string" required></div><br>
	<?php } ?>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

</div></main>
</body></html>