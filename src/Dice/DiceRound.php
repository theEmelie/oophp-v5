<?php
namespace Emau\Dice;

class DiceRound
{
    protected $hand;
    protected $roundScore;

    public function __construct(int $numOfDice = 2, int $diceSides = 6, int $roundScore = 0)
    {
        $this->hand = new DiceHand($numOfDice, $diceSides);
        $this->roundScore = $roundScore;
    }

    public function setRoundScore($score)
    {
        $this->roundScore = $score;
    }

    public function getRoundScore()
    {
        return $this->roundScore;
    }

    public function roll()
    {
        $roundOver = false;
        $this->hand->roll();
        $values = $this->hand->values();
        foreach ($values as $diceScore) {
            if ($diceScore == 1) {
                $this->roundScore = 0;
                $roundOver = true;
                break;
            }
        }
        if ($roundOver == false) {
            $this->roundScore += $this->hand->sum();
        }
        return $roundOver;
    }

    public function values()
    {
        return $this->hand->values();
    }
}
