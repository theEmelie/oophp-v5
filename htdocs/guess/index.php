<?php
require "autoload.php";
require "config.php";
require "src/Guess.php";

session_name("emau18");
session_start();

if (array_key_exists('number', $_SESSION)) {
    $number = intval($_SESSION['number']);
} else {
    $number = null;
}
if (array_key_exists('tries', $_SESSION)) {
    $tries = intval($_SESSION['tries']);
} else {
    $tries = null;
}
if (array_key_exists('maxTries', $_SESSION)) {
    $maxTries = intval($_SESSION['maxTries']);
} else {
    $maxTries = null;
}
if (array_key_exists('guess', $_POST)) {
    $guess = intval($_POST['guess']);
} else {
    $guess = null;
}
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;

if ($doInit || $number === null) {
    $number = rand(1, 100);
    $maxTries = 5;
    $tries = 1;
} elseif ($doGuess) {
    try {
        $game = new Guess($number, $maxTries, $tries);
        $res = $game->makeGuess($guess);
        $tries = $game->tries();
    } catch (GuessException $e) {
        $res = "Out of bounds. Enter a number between 1-100";
    }
}

$_SESSION["number"] = $number;
$_SESSION["maxTries"] = $maxTries;
$_SESSION["tries"] = $tries;

require "view/guess_my_number.php";
