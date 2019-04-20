<?php
namespace Emau\Dice;

use PHPUnit\Framework\TestCase;

class DiceHandTest extends TestCase
{
    // Test that rolling 2 dices works correctly
    public function testRollHand()
    {
        $hand = new DiceHand(2, 6);
        $hand->roll();
        $value = $hand->values();

        $this->assertGreaterThanOrEqual(1, $value[0]);
        $this->assertLessThanOrEqual(6, $value[0]);

        $this->assertGreaterThanOrEqual(1, $value[1]);
        $this->assertLessThanOrEqual(6, $value[1]);
    }

    // Test to see its the correct number of dice
    public function testCorrectNumOfDice()
    {
        $hand = new DiceHand(4, 6);
        $hand->roll();
        $value = $hand->values();
        $count = count($value);

        $this->assertEquals($count, 4);
    }

    // Test to see that the sum function works.
    public function testHandSum()
    {
        $hand = new DiceHand(4, 6);
        $hand->roll();
        $value = $hand->values();
        $sum = $value[0] + $value[1] + $value[2] + $value[3];

        $this->assertEquals($sum, $hand->sum());
    }
}
