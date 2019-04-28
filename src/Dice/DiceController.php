<?php
namespace Emau\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;
    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";
    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //     // Use $this->app to access the framework services.
    // }
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "active";
    }

    public function getDiceSessionData()
    {
        if ($this->app->session->has('game')) {
            $game = unserialize($this->app->session->get('game'));
        } else {
            $game = null;
        }
        $data = [
            "game" => $game
        ];
        return $data;
    }

    public function setDiceSessionData($data)
    {
        foreach ($data as $key => $value) {
            $this->app->session->set($key, $value);
        }
    }
    public function initAction()
    {
        // Init the session for the game start.
        $numOfDice = 2;
        $diceSides = 6;
        $maxScore = 100;
        $game = new DiceGame($numOfDice, $diceSides, $maxScore);
        $game->rollToStart();
        $data = [
            "game" => serialize($game),
        ];
        $this->setDiceSessionData($data);

        return $this->app->response->redirect("dice_game1/play_dice");
    }

    public function playActionGet()
    {
        $title = "Play the game";

        $data = $this->getDiceSessionData();
        $game = $data["game"];
        $output = $game->getGameData();

        // var_dump($output);


        $this->app->page->add("dice_game1/play_dice", $output);
        // $app->page->add("dice_game/debug");

        $data = [
            "game" => serialize($game),
        ];

        $this->setDiceSessionData($data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function playActionPost()
    {
        $data = $this->getDiceSessionData();
        $game = $data["game"];

        $doRoll = $this->app->request->getPost("doRoll") ?? null;
        $doSave = $this->$app->request->getPost("doSave") ?? null;
        $doReset = $this->$app->request->getPost("doReset") ?? null;
        $doComputer = $this->$app->request->getPost("doComputer") ?? null;

        if ($doReset) {
            return $app->response->redirect("dice_game1/init");
        } elseif ($doRoll) {
            $game->playRound();
        } elseif ($doSave) {
            $game->endPlayerRound();
        } elseif ($doComputer) {
            $game->playAIround();
        }

        $data = [
            "game" => serialize($game),
        ];
        $this->setDiceSessionData($data);

        return $this->app->response->redirect("dice_game1/play_dice");
    }
}
