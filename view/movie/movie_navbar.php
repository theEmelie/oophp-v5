<?php
namespace Anax\View;

// $req = new \Anax\Request\Request();
// echo("Site " . $req->getSiteUrl());
// echo("Base " . $req->getBaseUrl());
// echo("Current " . $req->getCurrentUrl());
// echo("Script " . $req->getScriptName());
?>
<div class="movieNav">
    <a href="<?=url('movie_first/init')?>">Movies | </a>
    <a href="<?=url('movie_first/searchTitle')?>">Search Title | </a>
    <a href="<?=url('movie_first/searchYear')?>">Search Year | </a>
    <a href="<?=url('movie_first/addMovie')?>">Add Movie </a>
</div>
