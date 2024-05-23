<?php

require_once("RPSLS.php");

class RPSLSOperator {
    private int $playerScore = 0;
    private int $opponentScore = 0;
    private int $pointsToWin;
    private RPSLS $rpsls;
    private array $elements;

    public function __construct()
    {
        $this->rpsls = new RPSLS();
        $this->elements = $this->rpsls->getElements();
    }

    private function setupGame(): void
    {
        echo "Welcome to RPSLS!\n";
        echo "Enter the amount of points to play for\n";
        while(true) {
            $points = readline("Required points to win - ");
            if (!is_numeric($points)) {
                echo "Points must be a numeric value\n";
                continue;
            }
            if ($points <= 0) {
                echo "Points must be greater than 0\n";
                continue;
            }
            $this->pointsToWin = $points;
            break;
        }
        
    }

    public function play(): void
    {
        $this->setupGame();

        while(true) {
            echo "Your score - $this->playerScore\n";
            echo "Opponent score - $this->opponentScore\n";
            if ($this->playerScore >= $this->pointsToWin) {
                echo "Congrats! You've won!\n";
                exit;
            }
            if ($this->opponentScore >= $this->pointsToWin) {
                echo "Oh no! You've lost!\n";
                exit;
            }
            $this->playRound();
        }
    }

    private function promptUserElement(): Element
    {
        echo "Pick an element! ";
        echo "(";
        foreach ($this->elements as $index => $element) {
            if ($index != 0) {
                echo ", ";
            }
            echo "{$element->name()}";
        }
        echo ")\n";

        while (true) {
            $userElement = strtolower(readline("Element - "));
            foreach ($this->elements as $element) {
                if ($userElement == $element->name()){
                    return $element;
                }
            }
            echo "Invalid element!\n";
        }
    }

    private function playRound(): void
    {
        $userElement = $this->promptUserElement();

        $opponentElement = $this->elements[array_rand($this->elements)];

        $winner = $this->rpsls->play($userElement, $opponentElement);

        echo "You picked {$userElement->name()}!\n";
        echo "Opponent picked {$opponentElement->name()}!\n";

        $verb = $userElement->verb($opponentElement);
        echo ucfirst("{$userElement->name()} $verb {$opponentElement->name()}!\n");

        switch ($winner) {
            case RPSLS::PLAYER:
                echo "You won the match!\n";
                $this->playerScore++;
                break;
            case RPSLS::OPPONENT:
                echo "You lost the match!\n";
                $this->opponentScore++;
                break;
            default:
                echo "It's a tie!\n";
        }
    }
}



