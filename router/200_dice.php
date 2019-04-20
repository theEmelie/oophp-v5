<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));
function getDiceSessionData($session)
{
    if (array_key_exists('game', $session)) {
        $game = unserialize($session['game']);
    } else {
        $game = null;
    }
    $data = [
        "game" => $game
    ];
    return $data;
}

function setDiceSessionData($data)
{
    foreach ($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
}
/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice_game/init", function () use ($app) {
    // Init the session for the game start.
    $numOfDice = 2;
    $diceSides = 6;
    $maxScore = 100;
    $game = new Emau\Dice\DiceGame($numOfDice, $diceSides, $maxScore);
    $game->rollToStart();
    $data = [
        "game" => serialize($game),
    ];
    setDiceSessionData($data);

    return $app->response->redirect("dice_game/play_dice");
});

/**
 * Play the game - show game status.
 */
$app->router->get("dice_game/play_dice", function () use ($app) {
    $title = "Play the game";

    $data = getDiceSessionData($_SESSION);
    $game = $data["game"];
    $output = $game->getGameData();

    // var_dump($output);


    $app->page->add("dice_game/play_dice", $output);
    // $app->page->add("dice_game/debug");

    $data = [
        "game" => serialize($game),
    ];

    setDiceSessionData($data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - make a guess.
 */
$app->router->post("dice_game/play_dice", function () use ($app) {
    $data = getDiceSessionData($_SESSION);
    $game = $data["game"];

    $doRoll = $_POST["doRoll"] ?? null;
    $doSave = $_POST["doSave"] ?? null;
    $doReset = $_POST["doReset"] ?? null;
    $doComputer = $_POST["doComputer"] ?? null;

    if ($doReset) {
        return $app->response->redirect("dice_game/init");
    } elseif ($doRoll) {
        $status = $game->playRound();
    } elseif ($doSave) {
        $game->endPlayerRound();
    } elseif ($doComputer) {
        $game->playAIround();
    }

    $data = [
        "game" => serialize($game),
    ];
    setDiceSessionData($data);

    return $app->response->redirect("dice_game/play_dice");
});
