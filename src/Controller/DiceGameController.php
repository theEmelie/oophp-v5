<?php

namespace Emau\DiceGameController;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class SampleController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }

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
        return __METHOD__ . ", \$db is {$this->db}";
    }

    public function initAction() : string
    {
        // Init the session for the game start.
        $numOfDice = 2;
        $diceSides = 6;
        $maxScore = 100;
        $game = new Emau\Dice\DiceGame($numOfDice, $diceSides, $maxScore);
        $game->rollToStart();
        $data = [
            "game" => serialize($game),
        ];
        setDiceSessionData($this->app, $data);
        return $this->app->response->redirect("dice_game/play_dice");
    }

    public function playDiceAction() : string
    {
        $title = "Play the game";

        $page = $this->app->page;
        $session = $this->app->session;

        $data = getDiceSessionData($app);
        $game = $data["game"];
        $output = $game->getGameData();

        $page->add("dice_game/play_dice", $output);

        $data = [
            "game" => serialize($game),
        ];

        setDiceSessionData($app, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function playDiceActionPost() : string
    {
        $app = $this->app
        $data = getDiceSessionData($app);
        $game = $data["game"];

        $doRoll = $app->request->getPost("doRoll") ?? null;
        $doSave = $app->request->getPost("doSave") ?? null;
        $doReset = $app->request->getPost("doReset") ?? null;
        $doComputer = $app->request->getPost("doComputer") ?? null;

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
        setDiceSessionData($app, $data);

        return $app->response->redirect("dice_game/play_dice");
    }
    /**
     * This sample method dumps the content of $di.
     * GET mountpoint/dump-app
     *
     * @return string
     */
    public function dumpDiActionGet() : string
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->di->getServices());
        return __METHOD__ . "<p>\$di contains: $services";
    }



    /**
     * Add the request method to the method name to limit what request methods
     * the handler supports.
     * GET mountpoint/info
     *
     * @return string
     */
    public function infoActionGet() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }



    /**
     * This sample method action it the handler for route:
     * GET mountpoint/create
     *
     * @return string
     */
    public function createActionGet() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }



    /**
     * This sample method action it the handler for route:
     * POST mountpoint/create
     *
     * @return string
     */
    public function createActionPost() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }



    /**
     * This sample method action takes one argument:
     * GET mountpoint/argument/<value>
     *
     * @param mixed $value
     *
     * @return string
     */
    public function argumentActionGet($value) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }



    /**
     * This sample method action takes zero or one argument and you can use - as a separator which will then be removed:
     * GET mountpoint/defaultargument/
     * GET mountpoint/defaultargument/<value>
     * GET mountpoint/default-argument/
     * GET mountpoint/default-argument/<value>
     *
     * @param mixed $value with a default string.
     *
     * @return string
     */
    public function defaultArgumentActionGet($value = "default") : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }



    /**
     * This sample method action takes two typed arguments:
     * GET mountpoint/typed-argument/<string>/<int>
     *
     * NOTE. Its recommended to not use int as type since it will still
     * accept numbers such as 2hundred givving a PHP NOTICE. So, its better to
     * deal with type check within the action method and throuw exceptions
     * when the expected type is not met.
     *
     * @param mixed $value with a default string.
     *
     * @return string
     */
    public function typedArgumentActionGet(string $str, int $int) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got string argument '$str' and int argument '$int'.";
    }



    /**
     * This sample method action takes a variadic list of arguments:
     * GET mountpoint/variadic/
     * GET mountpoint/variadic/<value>
     * GET mountpoint/variadic/<value>/<value>
     * GET mountpoint/variadic/<value>/<value>/<value>
     * etc.
     *
     * @param array $value as a variadic parameter.
     *
     * @return string
     */
    public function variadicActionGet(...$value) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value);
    }



    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. YOu can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
        // Deal with the request and send an actual response, or not.
        //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
        return;
    }
}
