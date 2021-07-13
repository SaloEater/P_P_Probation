<?php

namespace Modules\Convert\Domain\Dto;

class Exchange
{
    private string $from;
    private string $to;
    private float $value;

    public function __construct(string $from, string $to, float $value)
    {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}