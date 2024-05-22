<?php

require_once "Element.php";

class RPSLS {
    private ?string $winner = null;

    const PLAYER = "player";
    const OPPONENT = "opponent";

    const ROCK = "rock";
    const PAPER = "paper";
    const SCISSORS = "scissors";
    private array $elements = [];

    public function __construct()
    {
        $this->elements = [
            self::ROCK => new Element("rock"),
            self::PAPER => new Element("paper"),
            self::SCISSORS => new Element("scissors")
        ];
        $this->elements[self::ROCK]->setBeats([self::SCISSORS => "crushes"]);
        $this->elements[self::ROCK]->setLoses([self::PAPER => "is covered by"]);

        $this->elements[self::PAPER]->setBeats([self::ROCK => "covers"]);
        $this->elements[self::PAPER]->setLoses([self::SCISSORS => "is cut by"]);

        $this->elements[self::SCISSORS]->setBeats([self::PAPER => "cut"]);
        $this->elements[self::SCISSORS]->setLoses([self::ROCK => "is crushed by"]);
    }

    private function determineWinner(Element $playerElement, Element $opponentElement): ?string
    {
        if ($playerElement->beats($opponentElement)){
            return self::PLAYER;
        }
        if ($playerElement->loses($opponentElement)){
            return self::OPPONENT;
        }
        return null;
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

    private function announcePicks(Element $playerElement, Element $opponentElement): void
    {
        echo "You picked {$playerElement->name()}!\n";
        echo "Opponent picked {$opponentElement->name()}!\n";
    }

    public function play(Element $playerElement, Element $opponentElement): void
    {
        $this->winner = $this->determineWinner($playerElement, $opponentElement);
        $this->announcePicks($playerElement, $opponentElement);
        $this->announceMatch($playerElement, $opponentElement);
        $this->announceWinner();
    }

    public function getElements(): array
    {
        return $this->elements;
    }
}

$RPSLS = new RPSLS();
$possibleElements = array_keys($RPSLS->getElements());
echo "Pick an element! ";
echo "(";
foreach ($possibleElements as $index => $element) {
    if ($index != 0) {
        echo ", ";
    }
    echo "$element";
}
echo ")\n";

while(true) {
    $userElement = strtolower(readline("Element - "));
    if (!in_array($userElement, $possibleElements)) {
        echo "Invalid element!";
        continue;
    }
    break;
}

$opponentElement = $RPSLS->getElements()[array_rand($RPSLS->getElements())];

$RPSLS->play($RPSLS->getElements()[$userElement], $opponentElement);