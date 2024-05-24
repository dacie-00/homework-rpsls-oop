<?php

class Element
{
    private string $name;
    private array $relationships;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->relationships = ["beats" => [], "loses" => []];
    }

    public function beats(Element $element): bool
    {
        return isset($this->relationships["beats"][$element->name()]);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function loses(Element $element): bool
    {
        return isset($this->relationships["loses"][$element->name()]);
    }

    public function setBeats(array $beats): void
    {
        $this->relationships["beats"] = $beats;
    }

    public function setLoses(array $loses): void
    {
        $this->relationships["loses"] = $loses;
    }

    public function verb(Element $opponentElement): string
    {
        if (isset($this->relationships["beats"][$opponentElement->name()])) {
            return $this->relationships["beats"][$opponentElement->name()];
        }
        if (isset($this->relationships["loses"][$opponentElement->name()])) {
            return $this->relationships["loses"][$opponentElement->name()];
        }
        return "ties";
    }
}
