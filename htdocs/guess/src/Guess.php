<?php
/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
    * @var int $number   The current secret number.
    * @var int $tries    Number of tries a guess has been made.
    * @var int $maxTries Number of tries allowed.
    */
    private $number;
    private $tries;
    private $maxTries;

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $maxTries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $maxTries = 6, int $tries = 0)
    {
        $this->number = $number;
        $this->maxTries = $maxTries;
        $this->tries = $tries;
    }

    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */

    public function random()
    {
        $this->number = rand(1, 100);
    }

    /**
     * Return number of tries taken.
     *
     * @return int number of tries taken.
     */

    public function tries()
    {
        return $this->tries;
    }

    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */

    public function number()
    {
        return $this->number;
    }

    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess($guess)
    {
        // Check guesses inbounds
        if ($guess > 100 || $guess < 1) {
            throw new GuessException("Out of bounds");
        }
        if ($this->tries < $this->maxTries) {
            // Increment number of tries
            $this->tries++;
            // Check if correct
            if ($guess === $this->number) {
                return ("You win! Press 'Start From Beginning' to play again.");
            // Check if too high
            } elseif ($guess > $this->number) {
                return ("Your guess " . $guess . " is Too High");
            // Check if too low
            } elseif ($guess < $this->number) {
                return ("Your guess " . $guess . " is Too Low");
            } else {
                return ("You should never get here...");
            }
        } else {
            $this->tries = $this->maxTries + 1;
            return ("You lose! Correct number was: " . strval($this->number) .
                " Press 'Start From Beginning' to play again.");
        }
    }
}
