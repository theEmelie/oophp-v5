<?php
namespace Emau\Dice;

class DiceGame
{
    private $roundScore;
    private $playerScores = array();
    private $numOfDice;
    private $diceSides;
    private $maxScore;
    // public $numOfPlayers = 2;
    private $currentRound;
    private $inPlayerTurn;
    private $startRoll = [
        "humanPlayer" => 0,
        "aiPlayer" => 0
    ];
    private $resultMessage = "";
    private $humanTurn = true;
    private $gameOver;

    public function __construct(int $numOfDice = 2, int $diceSides = 6, int $maxScore = 100)
    {
        $this->numOfDice = $numOfDice;
        $this->diceSides = $diceSides;
        $this->maxScore = $maxScore;
        $this->inPlayerTurn = false;
        $this->gameOver = false;
        $this->playerScores[0] = 0;
        $this->playerScores[1] = 0;
        $this->roundScore = 0;
    }

    public function rollToStart()
    {
        $dice = new Dice($this->diceSides);
        while ($this->startRoll["humanPlayer"] == $this->startRoll["aiPlayer"]) {
            $this->startRoll = [
                "humanPlayer" => $dice->rollDice(),
                "aiPlayer" => $dice->rollDice()
            ];
        }
        if ($this->startRoll["humanPlayer"] < $this->startRoll["aiPlayer"]) {
            $this->humanTurn = false;
            $this->resultMessage = "You rolled: " . $this->startRoll["humanPlayer"] .
                " and Computer rolled " . $this->startRoll["aiPlayer"] . ". Therefore Computer starts.";
        } else {
            $this->humanTurn = true;
            $this->resultMessage = "You rolled: " . $this->startRoll["humanPlayer"] .
                " and Computer rolled " . $this->startRoll["aiPlayer"] . ". Therefore You start.";
        }
        return $this->startRoll;
    }

    public function getGameData()
    {
        if (isset($this->currentRound)) {
            $this->roundScore = $this->currentRound->getRoundScore();
        } else {
            $this->roundScore = 0;
        }
        $data = [
            "playerScores" => $this->playerScores,
            "currentScore" => $this->roundScore,
            "dice" => $this->getDice(),
            "resultMessage" => $this->resultMessage,
            "humanTurn" => $this->humanTurn,
            "inPlayerTurn" => $this->inPlayerTurn,
            "gameOver" => $this->gameOver
        ];
        return $data;
    }

    public function getDice()
    {
        if (isset($this->currentRound)) {
            return $this->currentRound->values();
        } else {
            return 0;
        }
    }

    public function checkWin()
    {
        if ($this->playerScores[0] >= $this->maxScore) {
            $this->resultMessage .= " You win!";
            $this->gameOver = true;
        }
        if ($this->playerScores[1] >= $this->maxScore) {
            $this->resultMessage .= " Computer wins!";
            $this->gameOver = true;
        }
    }

    public function setScores($scores)
    {
        $this->playerScores = $scores;
    }

    public function playRound()
    {
        $this->currentRound = new DiceRound($this->numOfDice, $this->diceSides, $this->roundScore);
        if ($this->inPlayerTurn == false) {
            $this->inPlayerTurn = true;
        }
        $roundOver = $this->currentRound->roll();
        if ($roundOver) {
            $this->resultMessage = "Busted, you rolled a 1.";
            $this->humanTurn = false;
        } else {
            $this->resultMessage = "You scored " . $this->currentRound->getRoundScore() . " this round.";
        }
        return $roundOver;
    }

    public function endPlayerRound()
    {
        $this->playerScores[0] += $this->roundScore;
        $this->resultMessage = "You added " . $this->roundScore . " to your total.";
        $this->roundScore = 0;
        $this->currentRound->setRoundScore(0);
        $this->humanTurn = false;
        $this->inPlayerTurn = false;
        $this->checkWin();
    }

    public function playAIround()
    {
        $maxRisk = 9;
        $diceRolls = "";
        $roundOver = false;

        $this->inPlayerTurn = false;
        $this->currentRound = new DiceRound($this->numOfDice, $this->diceSides, 0);

        while ($this->currentRound->getRoundScore() < $maxRisk && !$roundOver) {
            $roundOver = $this->currentRound->roll();
            $values = $this->currentRound->values();
            $diceRolls .= "[";
            foreach ($values as $die) {
                $diceRolls .= " " . $die;
            }
            $diceRolls .= " ]";
            $score = $this->playerScores[1] + $this->currentRound->getRoundScore();
            if ($score >= $this->maxScore) {
                break;
            }
        }
        if ($roundOver) {
            // Rolled 1
            $this->currentRound->setRoundScore(0);
            $this->resultMessage = "Computer rolled: " . $diceRolls . ". Computer busted, gets no points this round";
        } else {
            $aiPlayer = $this->currentRound->getRoundScore();
            $this->playerScores[1] += $aiPlayer;
            $this->resultMessage = "Computer rolled: " . $diceRolls . ". Computer scored " . $aiPlayer . " this round.";
            $this->currentRound->setRoundScore(0);
        }
        $this->humanTurn = true;
        $this->checkWin();
    }
}
