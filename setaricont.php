<?php
$pageTitle = "Setari cont";

include "session.php";
include "tools.php";

if(!isset($_session_id)) {
	header('Location: /');
	exit();
}

$err = "";


if ($_SERVER["REQUEST_METHOD"] != "POST")
	goto page_render;

if(!empty($_POST['pass']) && !empty($_POST['passNew']) && !empty($_POST['passConf'])) {
	$oldp = mysqli_real_escape_string($db, htmlspecialchars($_POST['pass']));
	$newp = mysqli_real_escape_string($db, htmlspecialchars($_POST['passNew']));
	$confp = mysqli_real_escape_string($db, htmlspecialchars($_POST['passConf']));
	if($newp != $confp) {
		$err = "Parolele nu corespund!";
		goto page_render;
	}

	$query = "SELECT * FROM Reprezentanti WHERE id='". $_session_id ."';";
	if($_session_isJudge) $query = "SELECT * FROM Magistrati WHERE id='". $_session_id ."';";
	$res = mysqli_query($db, $query);
	if ($row = mysqli_fetch_assoc($res)) {
		if(!empty($row["parola"])) {
			if(!password_verify($oldp, $row["parola"]) === true) {
				$err = "Parola gresita.";
				goto page_render;
			}
			$hash = password_hash($newp, PASSWORD_BCRYPT);
			$q = "UPDATE Reprezentanti SET parola='". $hash ."' WHERE id='". $_session_id ."';";
			if($_session_isJudge) $q = "UPDATE Magistrati SET parola='". $hash ."' WHERE id='". $_session_id ."';";
			mysqli_query($db, $q);
		}
	}
	header('Location: /setaricont.php');
	exit();
}
if(!empty($_POST['deleteSes'])) {
	$sid = mysqli_real_escape_string($db, htmlspecialchars($_POST['deleteSes']));
	$q = "DELETE FROM Sesiune WHERE id='". $sid ."';";
	mysqli_query($db, $q);
	header('Location: /');
	exit();
}
if(!empty($_POST['deleteAcc'])) {
	$q = "DELETE FROM Reprezentanti WHERE id='". $_session_id ."';";
	if($_session_isJudge)
		$q = "DELETE FROM Magistrati WHERE id='". $_session_id ."';";
	mysqli_query($db, $q);
	header('Location: /');
	exit();
}


page_render:

$sesiuni = [];
if($_session_isJudge)
	$q = "SELECT * FROM Sesiune WHERE userM=". $_session_idMagistrat .";";
else
	$q = "SELECT * FROM Sesiune WHERE userR=". $_session_idReprezentant .";";
$res = mysqli_query($db, $q);
while($row = mysqli_fetch_assoc($res))
	array_push($sesiuni, $row);

?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main><div class="container"><form method="post">

<div style="display:block;height:4rem;"></div>

<?php if($err != ""){
	?><div class="alert alert-danger" role="alert"><?php echo $err; ?></div><div style="display:block;height:1rem;"></div><?php
} ?>
<h1>Schimba parola</h1>
<div class="col-md-4"><label for="inputPass" class="form-label">Parola veche</label>
	<input name="pass" type="password" class="form-control" id="inputPass" placeholder="Scrieti.."></div><br>
<div class="col-md-4"><label for="inputPassword" class="form-label">Parola noua</label>
	<input name="passNew" type="password" class="form-control" id="inputPassword" placeholder="Creati o parola noua.."></div><br>
<div class="col-md-4"><label for="inputPassword2" class="form-label">Confirmare parola</label>
	<input name="passConf" type="password" class="form-control" id="inputPassword2" placeholder="Re-tastati parola noua.."></div><br>
<button type="submit" class="btn btn-primary">Schimba parola</button>

<div style="display:block;height:3rem;"></div><h1>Sesiuni curente</h1><ul class="list-group list-group-flush">
<?php

foreach($sesiuni as $ses) {
	$isMobile = (strpos(strtolower($ses["ua"]), "mobile")) !== false;
	?><li class="list-group-item"><span style="font-size:4rem"><i class="fa-solid <?php
	if($isMobile)
		echo 'fa-mobile-screen-button';
	else
		echo 'fa-computer';
	?>"></i>&nbsp;</span>
	<?php echo getBrowser($ses['ua']);
	if($isMobile) echo " Mobile";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID: "; $ses['id'];
	?> expira: <?php echo date("Y-m-d H:i:s", $ses["expires"]);
	?>&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="submit" name="deleteSes" class="btn btn-primary" value="<?php echo $ses['id']; ?>" >Sterge</button></li><?php
}

?></ul><div style="display:block;height:3rem;"></div><h1>Zona periculoasa</h1>
<button type="submit" name="deleteAcc" class="btn btn-danger" value="true" >Sterge contul</button>
</form></div>
</main>
</body></html>