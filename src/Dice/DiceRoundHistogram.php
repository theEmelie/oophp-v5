<?php

namespace Emau\Dice;

/**
 * A dice which has the ability to present data to be used for creating
 * a histogram.
 */
class DiceRoundHistogram extends DiceRound implements HistogramInterface
{
    use HistogramTrait;



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return max($this->serie);
    }



    /**
     * Roll the dice, remember its value in the serie and return
     * its value.
     *
     * @return int the value of the rolled dice.
     */
    public function roll()
    {
        $roundOver = false;
        $this->hand->roll();
        $values = $this->hand->values();
        foreach ($values as $diceScore) {
            $this->serie[] = $diceScore;
        }
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
}
