<?php

require_once "Element.php";

class RPSLS
{
    const PLAYER = "player";
    const OPPONENT = "opponent";
    private ?string $winner = null;
    private array $elements = [];

    public function __construct()
    {
        $rock = $this->addElement(new Element("rock"));
        $paper = $this->addElement(new Element("paper"));
        $scissors = $this->addElement(new Element("scissors"));
        $lizard = $this->addElement(new Element("lizard"));
        $spock = $this->addElement(new Element("spock"));

        $rock->setBeats([$scissors->name() => "crushes", $lizard->name() => "crushes"]);
        $rock->setLoses([$paper->name() => "is covered by", $spock->name() => "is vaporized by"]);

        $paper->setBeats([$rock->name() => "covers", $spock->name() => "disproves"]);
        $paper->setLoses([$scissors->name() => "is cut by", $lizard->name() => "is eaten by"]);

        $scissors->setBeats([$paper->name() => "cut", $lizard->name() => "decapitates"]);
        $scissors->setLoses([$rock->name() => "are crushed by", $spock->name() => "are smashed by"]);

        $lizard->setBeats([$spock->name() => "poisons", $paper->name() => "eats"]);
        $lizard->setLoses([$rock->name() => "is crushed by", $scissors->name() => "is decapitated by"]);

        $spock->setBeats([$scissors->name() => "smashes", $rock->name() => "vaporizes"]);
        $spock->setLoses([$paper->name() => "is disproved by", $lizard->name() => "is poisoned by"]);
    }

    private function addElement($element)
    {
        return $this->elements[array_push($this->elements, $element) - 1];
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