<?php
$pageTitle = "Adaugare dosar - Tribunalul BUCURESTI";

include "session.php";

$err = "";


if ($_SERVER["REQUEST_METHOD"] != "POST")
	goto page_render;
if(empty($_POST['numar']) || empty($_POST['materie']) || empty($_POST['obiect']) || empty($_POST['stadiu']) || empty($_POST['complet'])) {
	$err = "Completeaza toate campurile";
	goto page_render;
}

$_numar = mysqli_real_escape_string($db, htmlspecialchars($_POST['numar']));
$_materie = mysqli_real_escape_string($db, htmlspecialchars($_POST['materie']));
$_obiect = mysqli_real_escape_string($db, htmlspecialchars($_POST['obiect']));
$_stadiu = mysqli_real_escape_string($db, htmlspecialchars($_POST['stadiu']));
$_idcomplet = mysqli_real_escape_string($db, htmlspecialchars($_POST['complet']));

$q = "INSERT INTO Dosar (nrDosar,instanta,anDosar,idComplet,materie,obiect,stadiu,dataInreg,dataModif) VALUES ".
	"(". $_numar .",3,". date("Y") .",". $_idcomplet .",'". $_materie ."','". $_obiect ."','". $_stadiu ."','".
	date("Y-m-d H:i:s") ."','". date("Y-m-d H:i:s") ."');";

mysqli_query($db, $q);
header('Location: /dosare.php');
exit();

page_render:

$numar_dosar = 0;
$complet = [];

$res = mysqli_query($db, "SELECT MAX(id) FROM Dosar;");
if($row = mysqli_fetch_row($res))
	$numar_dosar = intval($row[0]) + 1;


$q = "SELECT C.*,S.tip FROM Complet C JOIN Sectii S ON C.idSectie=S.id;";
$res = mysqli_query($db, $q);
while($row = mysqli_fetch_assoc($res))
	array_push($complet, [htmlspecialchars($row["id"]), htmlspecialchars($row["nume"]), htmlspecialchars($row["tip"])]);

?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?><script>$(function () {
	$('[data-toggle="tooltip"]').tooltip()
  })</script></head><body><?php
	include "navbar.php";
?><main>
<div style="display:block;height:3rem;"></div>

<?php if($err != ""){
	?><div class="alert alert-danger" role="alert"><?php echo $err; ?></div><div style="display:block;height:2rem;"></div><?php
} ?>

<div class="input-group" style="width:50%;margin:auto"><form method="POST">

  <div class="form-group"><label for="inputNRD">Numar dosar</label>
	<input type="number" name="numar" class="form-control" id="inputNRD" min="0" value="<?php echo $numar_dosar; ?>" required></div><br>

  <div class="form-group"><label for="inputMat">Materie</label>
	<input type="text" name="materie" class="form-control" id="inputMat" maxlength="128" required></div><br>

  <div class="form-group"><label for="inputComp">Atribuiti un complet</label>
  <select id="inputComp" class="form-control" name="complet"><?php
  foreach($complet as $c) {
	echo '<option value="'. $c[0] .'">'. $c[1] .' - tip '. $c[2] .'</option>';
  } ?></select></div><br>

  <div class="form-group">
	<label for="inputObiect">Obiect</label>
	<textarea class="form-control" name="obiect" id="inputObiect" maxlength="32768" rows="4" required></textarea>
  </div>

  <div class="form-group"><label for="inputStad">Stadiu</label>
	<input type="text" name="stadiu" class="form-control" id="inputStad" maxlength="64" value="Fond" required></div><br>

  <button type="submit" class="btn btn-primary">Inregistrare</button>
</form></div>


</main>
</body></html>