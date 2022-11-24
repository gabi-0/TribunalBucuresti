<?php
$pageTitle = "Judecatoria SECTORULUI 3 | Login";


$judge = (empty($_GET['avocat']) && (empty($_GET['type']) || $_GET['type'] != "avocat") ? 1 : 0 );
$invalid_user = null;
$invalid_pass = null;


if ($_SERVER["REQUEST_METHOD"] != "POST")
	goto skip_exec;
if(empty($_POST['user'])) {
	$invalid_user = 1;
	goto skip_exec;
}
if(empty($_POST['pass'])) {
	$invalid_pass = 1;
	goto skip_exec;
}

include "init.php";

$user = mysqli_real_escape_string($db, htmlspecialchars($_POST['user']));
$pass = mysqli_real_escape_string($db, htmlspecialchars($_POST['pass']));

$query = "SELECT numeRepr, userRepr, parolaRepr AS parola FROM Persoane WHERE userRepr='". $user ."';";
if($judge) $query = "SELECT * FROM Magistrati WHERE user='". $user ."';";

$res = mysqli_query($db, $query);

// user not found
if (mysqli_num_rows($res) == 0) {
	$invalid_user = 1;
	goto skip_exec;
}

// password check
$invalid_user = 0;
$row = mysqli_fetch_assoc($res);
if (empty($row["parola"])) {
	$invalid_pass = 1;
	goto skip_exec;
}
if(password_verify($pass, $row["parola"]) === false) {
	$invalid_pass = 1;
	goto skip_exec;
}

// create session

skip_exec:

if(isset($res))
	mysqli_free_result($res);


?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php

include "init.php"

?><main>
	<div class="container"><form method="post">

	<div class="col-md-4"><label for="invalidationUsername" class="form-label">Username</label>
	<div class="input-group has-invalidation"><?php if(!$judge){ ?><span class="input-group-text" id="inputGroupPrepend">@</span><?php } ?>
		<input name="user" type="text" class="<?php if($invalid_user) echo "is-invalid"; else if($invalid_user === 0) echo "is-valid";
		?> form-control" id="invalidationUsername" aria-describedby="inputGroupPrepend" placeholder="Scrieti.." required>
		<div class="invalid-feedback">Username inexistent</div>
		</div></div><br>

	<div class="col-md-4"><label for="inputPassword" class="form-label">Parola</label>
		<input name="pass" type="password" class="<?php if($invalid_pass) echo "is-invalid";
		?>form-control" id="inputPassword" placeholder="Scrieti.." required>
		<div class="invalid-feedback">Parola incorecta</div>
		</div>

	<div class="form-check"><input name="remember" type="checkbox" class="form-check-input" id="exampleCheck">
		<label class="form-check-label" for="exampleCheck">Ramai autentificat</label></div><br>
	<button type="submit" class="btn btn-primary float-right">Autentificare</button>
	</form></div><?php echo $judge; ?>
</main>
</body></html>