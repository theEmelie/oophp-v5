<?php
namespace Emau\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class Dice
{
    private $diceSides;
    /**
    * @var int $lastRoll  Value of the last roll.
    */
    protected $lastRoll;

    public function __construct(int $diceSides = 6)
    {
        $this->diceSides = $diceSides;
    }

    public function rollDice()
    {
        $this->lastRoll = rand(1, $this->diceSides);
        return $this->lastRoll;
    }

    public function getLastRoll()
    {
        return $this->lastRoll;
    }

    public function getNumOfSides()
    {
        return $this->diceSides;
    }
}
