<?php

require_once "Element.php";

class RPSLS
{
    const PLAYER = "player";
    const OPPONENT = "opponent";
    const ROCK = "rock";
    const PAPER = "paper";
    const SCISSORS = "scissors";
    private ?string $winner = null;
    private array $elements = [];

    public function __construct()
    {
        $rock = $this->elements[array_push($this->elements, new Element("rock")) - 1];
        $paper = $this->elements[array_push($this->elements, new Element("paper")) - 1];
        $scissors = $this->elements[array_push($this->elements, new Element("scissors")) - 1];

        $rock->setBeats([self::SCISSORS => "crushes"]);
        $rock->setLoses([self::PAPER => "is covered by"]);

        $paper->setBeats([self::ROCK => "covers"]);
        $paper->setLoses([self::SCISSORS => "is cut by"]);

        $scissors->setBeats([self::PAPER => "cut"]);
        $scissors->setLoses([self::ROCK => "is crushed by"]);
    }

    public function play(Element $playerElement, Element $opponentElement): void
    {
        $this->winner = $this->determineWinner($playerElement, $opponentElement);
        $this->announcePicks($playerElement, $opponentElement);
        $this->announceMatch($playerElement, $opponentElement);
        $this->announceWinner();
    }

    private function determineWinner(Element $playerElement, Element $opponentElement): ?string
    {
        if ($playerElement->beats($opponentElement)) {
            return self::PLAYER;
        }
        if ($playerElement->loses($opponentElement)) {
            return self::OPPONENT;
        }
        return null;
    }

    private function announcePicks(Element $playerElement, Element $opponentElement): void
    {
        echo "You picked {$playerElement->name()}!\n";
        echo "Opponent picked {$opponentElement->name()}!\n";
    }

    private function announceMatch(Element $playerElement, Element $opponentElement): void
    {
        $verb = $playerElement->verb($opponentElement);
        echo ucfirst("{$playerElement->name()} $verb {$opponentElement->name()}!\n");
    }

    private function announceWinner()
    {
        switch ($this->winner) {
            case self::PLAYER:
                echo "You won!\n";
                return;
            case self::OPPONENT:
                echo "You lost!\n";
                return;
            default:
                echo "It's a tie!\n";
        }
    }

    public function getElements(): array
    {
        return $this->elements;
    }
}

$RPSLS = new RPSLS();
$elements = $RPSLS->getElements();

echo "Pick an element! ";
echo "(";
foreach ($elements as $index => $element) {
    if ($index != 0) {
        echo ", ";
    }
    echo "{$element->name()}";
}
echo ")\n";

while (true) {
    $userElement = strtolower(readline("Element - "));
    foreach ($elements as $element) {
        if ($userElement == $element->name()){
            $userElement = $element;
            break 2;
        }
    }
    echo "Invalid element!\n";
}

$opponentElement = $elements[array_rand($elements)];

$RPSLS->play($userElement, $opponentElement);