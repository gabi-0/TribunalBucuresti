<?php
$pageTitle = "Cautare dosare";

include "session.php";
include "init.php";

$limit = 10;
$numep = "";
$an = date('Y');

if(empty($_GET['an'])) {
    goto page_render;
}

$an = mysqli_real_escape_string($db, htmlspecialchars($_GET['an']));

if(!empty($_GET["limit"]))
    $limit = mysqli_real_escape_string($db, htmlspecialchars($_GET['limit']));

$data = [];

$q = 
"SELECT D.*,C.nume,S.tip FROM Dosar D JOIN Complet C ON D.idComplet=C.id JOIN Sectii S ON C.idSectie=S.id WHERE D.anDosar='". $an
    ."' AND D.id IN (SELECT D.id FROM Magistrati M JOIN Dosar D ON D.idComplet=M.idComplet WHERE M.id='". $_session_id
    ."') ORDER BY D.id DESC LIMIT ". $limit;
$res = mysqli_query($db, $q);
while($row = mysqli_fetch_assoc($res))
    array_push($data, $row);


page_render:

?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main><form method="get">

<div style="display:block;height:2rem;"></div>
<div class="input-group" style="width:30%;margin:auto">
<input name="an" type="number" class="form-control rounded" placeholder="Introduceti anul" aria-label="Search" min="1990"
max="<?php echo date('Y')+10; ?>" value="<?php echo $an; ?>" aria-describedby="search-addon" />
<button type="submit" class="btn btn-outline-primary">search</button></div></form>

<div style="display:block;height:2rem;"></div>
<div style="width:85%;margin:auto;"><table class="table table-striped"><thead><tr>
  <th scope="col" style="width:10%">#</th><th scope="col" style="width:13%">Data</th><th scope="col" style="width:30%">Obiect</th>
  <th scope="col" style="width:13%">Materie</th><th scope="col" style="width:5%">Stadiu</th>
  <th scope="col" style="width:6%">Complet</th><th scope="col" style="width:19%">Sectie</th></tr>
</thead><tbody><?php

if(isset($data)) {
foreach($data as $dosar) {
    ?><tr><td><a href="/dosar.php?id=<?php echo $dosar['id'] ?>"><?php
    echo $dosar['nrDosar'] .'/'. $dosar['instanta'] .'/'. $dosar['anDosar']; ?></a></td>
    <td><?php echo $dosar['dataModif']; ?></td><td><?php echo $dosar['obiect']; ?></td>
    <td><?php echo $dosar['materie']; ?></td><td><?php echo $dosar['stadiu']; ?></td>
    <td><?php echo $dosar['nume']; ?></td><td><?php echo $dosar['tip']; ?></td></tr><?php
}}
?></tbody></table></div></main>
</body></html>