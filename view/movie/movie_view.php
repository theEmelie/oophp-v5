<?php
$movie = $res[0]; ?>

<ul>
    <li><b>Id:</b> <?= $movie->id ?></li>
    <li><b>Title:</b> <?= $movie->title ?></li>
    <li><b>Year:</b> <?= $movie->year ?></li>
    <li><b>Image:</b> <?= $movie->image ?></li>
    <li><b>Director:</b> <?= $movie->director ?></li>
    <li><b>Plot:</b> <?= $movie->plot ?></li>
    <li><b>Length:</b> <?= $movie->length ?></li>
    <li><b>Subtext:</b> <?= $movie->subtext ?></li>
    <li><b>Speech:</b> <?= $movie->speech ?></li>
    <li><b>Quality:</b> <?= $movie->quality ?></li>
    <li><b>Format:</b> <?= $movie->format ?></li>
</ul>
