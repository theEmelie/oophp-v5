<?php
namespace Emau\Dice;

use PHPUnit\Framework\TestCase;

class DiceGameTest extends TestCase
{
    // Test to see who get to start the round
    public function testStartRoll()
    {
        // Set random seed so we know what value will be generated
        srand(3);
        $game = new DiceGame(2, 6, 100);
        $start = $game->rollToStart();

        $this->assertEquals($start["humanPlayer"], 5);
        $this->assertEquals($start["aiPlayer"], 3);
    }

    // Test to play a round
    public function testPlayRound()
    {
        // Set random seed so we know what value will be generated
        srand(3);
        $game = new DiceGame(2, 6, 100);

        $roundStatus = $game->playRound();
        $value = $game->getDice();

        $this->assertEquals($value[0], 5);
        $this->assertEquals($value[1], 3);
        $this->assertFalse($roundStatus);
    }

    // Test to see that computer will win
    public function testComputerWin()
    {
        $game = new DiceGame(2, 6, 100);

        $game->setScores([2, 100]);
        $game->checkwin();
        $data = $game->getGameData();
        $this->assertEquals($data["resultMessage"], " Computer wins!");
        $this->assertTrue($data["gameOver"]);
    }

    // Test to see that player will win
    public function testPlayerWin()
    {
        $game = new DiceGame(2, 6, 100);

        $game->setScores([100, 10]);
        $game->checkwin();
        $data = $game->getGameData();
        $this->assertEquals($data["resultMessage"], " You win!");
        $this->assertTrue($data["gameOver"]);
    }

    // Test to see that no one wins
    public function testNoWin()
    {
        $game = new DiceGame(2, 6, 100);

        $game->setScores([99, 99]);
        $game->checkwin();
        $data = $game->getGameData();
        $this->assertFalse($data["gameOver"]);
    }
}
