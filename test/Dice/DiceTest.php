<?php
namespace Emau\Dice;

use PHPUnit\Framework\TestCase;

class DiceTest extends TestCase
{
    // Test roll dice function
    public function testRollDice()
    {
        $dice = new Dice(6);
        $roll = $dice->rollDice();

        $this->assertGreaterThanOrEqual(1, $roll);
        $this->assertLessThanOrEqual(6, $roll);
    }

    // Test getting the last roll
    public function testGetLastRoll()
    {
        $dice = new Dice(6);
        $roll = $dice->rollDice();
        $lastRoll = $dice->getLastRoll();

        $this->assertEquals($lastRoll, $roll);
    }

    // Test if the dice sides are correct
    public function testGetSides()
    {
        $dice = new Dice(6);
        $sides = $dice->getNumOfSides();

        $this->assertEquals($sides, 6);
    }
}
