<?php
namespace Emau\Dice;

class DiceHand
{
    private $numOfDice;
    private $diceSides;
    private $diceArray = array();
    private $valueArray = array();

    public function __construct(int $numOfDice = 2, int $diceSides = 6)
    {
        $this->numOfDice = $numOfDice;
        $this->diceSides = $diceSides;

        for ($i = 0; $i < $numOfDice; $i++) {
            $this->diceArray[$i] = new Dice($diceSides);
            $this->valueArray[$i] = null;
        }
    }
    /**
    * Roll all dices save their value.
    *
    * @return void.
    */
    public function roll()
    {
        for ($i = 0; $i < $this->numOfDice; $i++) {
            $this->valueArray[$i] = $this->diceArray[$i]->rollDice();
        }
    }

    /**
    * Get values of dices from last roll.
    *
    * @return array with values of the last roll.
    */
    public function values()
    {
        return $this->valueArray;
    }

    /**
    * Get the sum of all dices.
    *
    * @return int as the sum of all dices.
    */
    public function sum()
    {
        $sum = 0;

        for ($i = 0; $i < $this->numOfDice; $i++) {
            $sum += $this->valueArray[$i];
        }
        return $sum;
    }
}
