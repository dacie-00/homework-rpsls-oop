<?php

class Element
{
    private string $symbol;
    private string $name;
    private array $relationships;

    public function __construct(string $symbol, string $name)
    {
        $this->symbol = $symbol;
        $this->name = $name;
        $this->relationships = ["beats" => [], "loses" => []];
    }

    public function beats(Element $element)
    {
        return in_array($element, $this->relationships["beats"]);
    }

    public function symbol()
    {
        return $this->symbol;
    }

    public function name()
    {
        return $this->name;
    }
}