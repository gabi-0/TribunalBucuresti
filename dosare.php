<?php
$pageTitle = "Cautare dosare";

include "session.php";
include "init.php";

$limit = 10;
$numep = "";

if(!empty($_GET["limit"]))
    $limit = mysqli_real_escape_string($db, htmlspecialchars($_GET['limit']));
if(!empty($_GET["numep"]))
    $numep = mysqli_real_escape_string($db, htmlspecialchars($_GET['numep']));

$data = [];

$q = '';
if($numep == '')
    $q = "SELECT D.*,C.nume,S.tip FROM Dosar D JOIN Complet C ON D.idComplet=C.id JOIN Sectii S ON C.idSectie=S.id ORDER BY D.id DESC LIMIT ".
        $limit .";";
else
    $q = "SELECT D.*,C.nume,S.tip FROM Persoane P JOIN Parti PT ON P.id=PT.idPersoana JOIN Dosar D ON D.id=PT.idDosar ".
        " JOIN Complet C ON D.idComplet=C.id JOIN Sectii S ON C.idSectie=S.id WHERE P.nume LIKE '%". $numep ."%' LIMIT ". $limit .";";
$res = mysqli_query($db, $q);
while($row = mysqli_fetch_assoc($res))
    array_push($data, $row);


?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main>
<div style="display:block;height:4rem;"></div>
<div style="width:85%;margin:auto;"><form method="get" action="/dosare.php">
<div class="input-group" style="width:50%;margin:auto">
<input name="numep" type="search" class="form-control rounded" placeholder="Cauta o persoana" aria-label="Search" aria-describedby="search-addon" />
<button type="button" class="btn btn-outline-primary">search</button></div></form>
<div style="display:block;height:2rem;"></div><?php
if(!empty($_GET["numep"]) || $limit != 10) {
?><div class="alert alert-secondary" role="alert"><?php
    echo "Afiseaza ". sizeof($data) ." dosare";
    if(!empty($_GET["numep"]))
        echo " care contin persoana '". $numep ."'";
    echo "."; ?></div><?php
} ?><table class="table table-striped"><thead><tr>
  <th scope="col" style="width:10%">#</th><th scope="col" style="width:13%">Data</th><th scope="col" style="width:30%">Obiect</th>
  <th scope="col" style="width:13%">Materie</th><th scope="col" style="width:5%">Stadiu</th>
  <th scope="col" style="width:6%">Complet</th><th scope="col" style="width:19%">Sectie</th></tr>
</thead><tbody><?php

foreach($data as $dosar) {
    ?><tr><td><a href="/dosar.php?id=<?php echo $dosar['id'] ?>"><?php
    echo $dosar['nrDosar'] .'/'. $dosar['instanta'] .'/'. $dosar['anDosar']; ?></a></td>
    <td><?php echo $dosar['dataModif']; ?></td><td><?php echo $dosar['obiect']; ?></td>
    <td><?php echo $dosar['materie']; ?></td><td><?php echo $dosar['stadiu']; ?></td>
    <td><?php echo $dosar['nume']; ?></td><td><?php echo $dosar['tip']; ?></td></tr><?php
}
?></tbody></table><br><br><p><?php

function moreRes($nr) {
    global $limit, $numep;
    ?><a href="/dosare.php?limit=<?php echo $limit+$nr;
    if($numep) echo "&numep=". $numep;
    ?>">Afiseaza inca <?php echo $nr; ?> rezultate</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php
}
moreRes(10);
moreRes(50);
moreRes(100);

?></p></div></main></body></html>