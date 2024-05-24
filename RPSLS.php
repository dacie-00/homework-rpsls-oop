<?php

require_once "Element.php";

class RPSLS
{
    const PLAYER = "player";
    const OPPONENT = "opponent";
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

    private function addElement(Element $element): Element
    {
        return $this->elements[array_push($this->elements, $element) - 1];
    }

    public function play(Element $playerElement, Element $opponentElement): ?string
    {
        if ($playerElement->beats($opponentElement)) {
            return self::PLAYER;
        }
        if ($playerElement->loses($opponentElement)) {
            return self::OPPONENT;
        }
        return null;
    }

    public function getElements(): array
    {
        return $this->elements;
    }
}
