<?php
namespace Emau\Dice;

use PHPUnit\Framework\TestCase;

class DiceRoundHistogramTest extends TestCase
{
    // Test setting round score
    public function testCreateRoundScore()
    {
        $round = new DiceRoundHistogram(2, 6, 3);
        $this->assertEquals($round->getRoundScore(), 3);
    }

    // Test getting the round score
    public function testGetSetRoundScore()
    {
        $round = new DiceRoundHistogram(2, 6, 3);
        $round->setRoundScore(5);
        $this->assertEquals($round->getRoundScore(), 5);
    }

    // Test to get roundOver to true when getting a 1.
    public function testRoll()
    {
        // Set random seed so we know what value will be generated
        srand(3);
        $round = new DiceRoundHistogram(2, 6, 3);

        $roundOver = $round->roll();
        $value = $round->values();
        $this->assertFalse($roundOver);
        $this->assertEquals($value[0], 5);
        $this->assertEquals($value[1], 3);

        $roundOver = $round->roll();
        $value = $round->values();
        $this->assertFalse($roundOver);
        $this->assertEquals($value[0], 2);
        $this->assertEquals($value[1], 4);

        $roundOver = $round->roll();
        $value = $round->values();
        $this->assertTrue($roundOver);
        $this->assertEquals($value[0], 5);
        $this->assertEquals($value[1], 1);
    }
}
