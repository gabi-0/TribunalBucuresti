<?php
$pageTitle = "Tribunalul BUCURESTI";


include "session.php";
include "init.php";


if(empty($_GET["id"]))
    goto page_render;

$did = mysqli_real_escape_string($db, htmlspecialchars($_GET["id"]));

if ($_SERVER["REQUEST_METHOD"] != "POST")
    goto page_render;
if(empty($_GET["id"]) || empty($_POST["obiect"])) {
	goto page_render;
}

$obiect = mysqli_real_escape_string($db, htmlspecialchars($_POST["obiect"]));

$q = "UPDATE Dosar SET obiect='". $obiect ."' WHERE id='". $did ."';";
$res = mysqli_query($db, $q);

page_render:

if(!empty($_GET["id"])) {
    $q = "SELECT obiect FROM Dosar WHERE id='". $did ."';";
    $res = mysqli_query($db, $q);
    $row = mysqli_fetch_row($res);
    $obiect = $row[0];
}


?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main>
<div style="display:block;height:3rem;"></div>

<div class="input-group" style="width:50%;margin:auto"><form <?php if(!empty($_GET["id"])) echo 'method="post"'; ?> >

  <div class="form-group"><label for="inputNRD">Numar dosar</label>
	<input type="number" name="id" class="form-control" id="inputNRD" min="1" value="<?php echo $did; ?>" <?php
    if(!empty($_GET["id"])) echo 'disabled'; ?>></div><br><?php

    if(!empty($_GET["id"])) {
  ?><div class="form-group">
	<label for="inputObiect">Obiect</label>
	<textarea class="form-control" name="obiect" id="inputObiect" maxlength="32768" rows="4" required><?php echo $obiect; ?></textarea>
  </div><?php } ?>

  <button type="submit" class="btn btn-primary">Modifica</button>
</form></div>


</main>
</body></html>