<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));
function getSessionData($session)
{
    if (array_key_exists('number', $session)) {
        $number = intval($session['number']);
    } else {
        $number = null;
    }
    if (array_key_exists('tries', $session)) {
        $tries = intval($session['tries']);
    } else {
        $tries = null;
    }
    if (array_key_exists('maxTries', $session)) {
        $maxTries = intval($session['maxTries']);
    } else {
        $maxTries = null;
    }
    if (array_key_exists('res', $session)) {
        $res = $session['res'];
    } else {
        $res = null;
    }
    $data = [
        "tries" => $tries,
        "maxTries" => $maxTries,
        "res" => $res,
        "number" => $number,
    ];
    return $data;
}

function setSessionData($data)
{
    foreach ($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
}
/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess_game/init", function () use ($app) {
    // Init the session for the game start.
    $number = rand(1, 100);
    $maxTries = 5;
    $tries = 1;
    $game = new Emau\Guess\Guess($number, $maxTries, $tries);

    $data = [
        "number" => $number,
        "maxTries" => $maxTries,
        "tries" => $tries,
        "res" => "",
    ];
    setSessionData($data);

    return $app->response->redirect("guess_game/play");
});

/**
 * Play the game - show game status.
 */
$app->router->get("guess_game/play", function () use ($app) {
    $title = "Play the game";

    $sess = getSessionData($_SESSION);
    $res = $sess["res"] ?? null;

    $data = [
        "guess" => $sess["guess"] ?? null,
        "tries" =>  $sess["tries"],
        "maxTries" =>  $sess["maxTries"],
        "res" => $sess["res"],
        "number" =>  $sess["number"] ?? null,
    ];

    $app->page->add("guess_game/play", $data);
    $app->page->add("guess_game/debug");

    setSessionData($data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - make a guess.
 */
$app->router->post("guess_game/play", function () use ($app) {
    $sess = getSessionData($_SESSION);

    if (array_key_exists('guess', $_POST)) {
        $guess = intval($_POST['guess']);
    } else {
        $guess = null;
    }

    $doGuess = $_POST["doGuess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;

    if ($doInit || $sess["number"] === null) {
        $sess["number"] = rand(1, 100);
        $maxTries["maxTries"] = 5;
        $tries = 1;
        $res = "";
    } elseif ($doGuess) {
        try {
            $game = new Emau\Guess\Guess($sess["number"], $sess["maxTries"], $sess["tries"]);
            $res = $game->makeGuess($guess);
            $tries = $game->tries();
        } catch (Emau\Guess\GuessException $e) {
            $res = "Out of bounds. Enter a number between 1-100";
            $tries = $game->tries();
        }
    }
    $data = [
        "tries" =>  $tries,
        "maxTries" =>  $sess["maxTries"],
        "res" => $res,
        "number" =>  $sess["number"],
    ];
    setSessionData($data);

    return $app->response->redirect("guess_game/play");
});
