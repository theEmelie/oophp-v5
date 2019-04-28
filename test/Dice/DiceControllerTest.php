<?php
namespace Emau\Dice;

use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

class DiceControllerTest extends TestCase
{
    private $controller;
    /**
    * Setup the controller, before each testcase, just like the router
    * would set it up.
    */
    protected function setUp(): void
    {
        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $app = $di;
        $di->set("app", $app);
        // Create and initiate the controller
        $this->controller = new DiceController();
        $this->controller->setApp($app);
        // $this->controller->initialize();
    }

    /**
     * Call the controller index action.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertIsString($res);
        $this->assertStringEndsWith("active", $res);
    }
    // public function testSetGetDiceSessionData()
    // {
    //     $game = [
    //         "value1" => 4,
    //         "value2" => "value"
    //     ];
    //     $data = [
    //         "game" => serialize($game),
    //     ];
    //     $this->controller->setDiceSessionData($data);
    //     $sessionData = $this->controller->getDiceSessionData();
    //
    //     $sessionGame = $sessionData["game"];
    //     $this->assertEquals($sessionGame["value1"], 4);
    //     $this->assertEquals($sessionGame["value2"], "value");
    // }
    //
}
