<?php

namespace Emau\Dice;

/**
 * A trait implementing HistogramInterface.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  The numbers stored in sequence.
     */
    private $serie = [];



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin()
    {
        return 1;
    }



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return $this->diceSides;
    }

    /**
    * Return a string with a textual representation of the histogram.
    *
    * @return string representing the histogram.
    */
    public function getAsText()
    {
        $str = "";
        $hist = array();
        foreach ($this->serie as $data) {
            if (array_key_exists($data, $hist)) {
                $hist[$data]++;
            } else {
                $hist[$data] = 1;
            }
        }
        $count = max(array_keys($hist));
        for ($i = 1; $i <= $count; $i++) {
            if (array_key_exists($i, $hist)) {
                $str .= $i . ": " . str_repeat("*", $hist[$i]) . "<br>";
            } else {
                $str .= $i . ": <br>";
            }
        }
        return $str;
    }
}
