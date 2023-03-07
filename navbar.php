<?php

$homeName = 'Tribunalul BUCURESTI';

?><nav class="navbar navbar-expand-lg bg-light"><div class="container-fluid">
	<a class="navbar-brand" href="/"><?php echo $homeName; ?></a>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
	aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent"><ul class="navbar-nav me-auto mb-2 mb-lg-0">
		<li class="nav-item"><a class="nav-link" href="/dosare.php">Dosare</a></li>
		<li class="nav-item"><a class="nav-link" href="#">Sedinte</a></li>
		<li class="nav-item"><a class="nav-link" href="/sectii.php">Organizare</a></li>
		</ul><?php

if(isset($_session_id)) {

	?><div class="nav-item dropdown" style="padding-right:5rem;"><a class="nav-link dropdown-toggle" href="#" role="button"
	data-bs-toggle="dropdown" aria-expanded="false"><?php
	if($_session_isJudge) echo '<i class="fa-solid fa-gavel fa-flip-horizontal"></i>';
	else '<i class="fa-solid fa-scale-balanced"></i>';
	echo $_session_nume ." ". $_session_prenume;
	?></a><ul class="dropdown-menu float-right">
		<li><a class="dropdown-item" href="/sedinte.php"><i class="fa-solid fa-landmark"></i>Sedinte</a></li>
		<li><a class="dropdown-item" href="/magdosare.php"><i class="fa-regular fa-folder"></i>Dosarele mele</a></li>
		<li><a class="dropdown-item" href="/dosarnou.php"><i class="fa-solid fa-plus"></i></i>Adauga dosar</a></li>
		<li><a class="dropdown-item" href="/setaricont.php"><i class="fa-solid fa-gears"></i>Setari</a></li>
		<li><hr class="dropdown-divider"></li>
		<li><a class="dropdown-item" href="/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i>Iesiti din cont</a></li>
		</ul></div><?php

} else {

	?><div class="nav-item dropdown" style="padding-right:5rem;"><a class="nav-link dropdown-toggle" href="#" role="button"
	data-bs-toggle="dropdown" aria-expanded="false">Autentificare</a><ul class="dropdown-menu float-right">
		<li><a class="dropdown-item" href="/login.php"><i class="fa-solid fa-gavel fa-flip-horizontal"></i>Judecator</a></li>
		<li><a class="dropdown-item" href="/login.php?avocat=1"><i class="fa-solid fa-scale-balanced"></i>Avocat</a></li>
		</ul></div><?php
}
	?></div></nav>