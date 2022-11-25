<?php
$pageTitle = "Sectii - Tribunalul BUCURESTI";

include "session.php";


?><!DOCTYPE html><html lang="ro"><head><?php include "head.php"; ?></head><body><?php
	include "navbar.php";
?><main><?php

include "init.php";
include "tools.php";

$query = "SELECT S.id AS SID, S.tip, S.presedinte, M.* FROM Sectii S LEFT JOIN Magistrati M ON M.id=S.presedinte;";
$res = mysqli_query($db, $query);

while($row = mysqli_fetch_assoc($res)) {
	?><div class="container"><h3 class="display-6">Sectia <?php
		echo ordinalRoman($row["SID"]);
		echo " ". $row["tip"];
	?></h3><p>Presedinte <?php echo $row["nume"] ." ". $row["prenume"]; ?></p></div><?php
}

?></main>
</body></html>