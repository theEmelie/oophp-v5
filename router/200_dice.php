<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));
function getDiceSessionData($app)
{
    if ($app->session->has('game')) {
        $game = unserialize($app->session->get('game'));
    } else {
        $game = null;
    }
    $data = [
        "game" => $game
    ];
    return $data;
}

function setDiceSessionData($app, $data)
{
    foreach ($data as $key => $value) {
        $app->session->set($key, $value);
    }
}
/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice_game1/init", function () use ($app) {
    // Init the session for the game start.
    $numOfDice = 2;
    $diceSides = 6;
    $maxScore = 100;
    $game = new Emau\Dice\DiceGame($numOfDice, $diceSides, $maxScore);
    $game->rollToStart();
    $data = [
        "game" => serialize($game),
    ];
    setDiceSessionData($app, $data);

    return $app->response->redirect("dice_game1/play_dice");
});

/**
 * Play the game - show game status.
 */
$app->router->get("dice_game1/play_dice", function () use ($app) {
    $title = "Play the game";

    $data = getDiceSessionData($app);
    $game = $data["game"];
    $output = $game->getGameData();

    // var_dump($output);


    $app->page->add("dice_game1/play_dice", $output);
    // $app->page->add("dice_game/debug");

    $data = [
        "game" => serialize($game),
    ];

    setDiceSessionData($app, $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - make a guess.
 */
$app->router->post("dice_game1/play_dice", function () use ($app) {
    $data = getDiceSessionData($app);
    $game = $data["game"];

    $doRoll = $app->request->getPost("doRoll") ?? null;
    $doSave = $app->request->getPost("doSave") ?? null;
    $doReset = $app->request->getPost("doReset") ?? null;
    $doComputer = $app->request->getPost("doComputer") ?? null;

    if ($doReset) {
        return $app->response->redirect("dice_game1/init");
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
    setDiceSessionData($app, $data);

    return $app->response->redirect("dice_game1/play_dice");
});
