<?php

namespace Modules\Convert\Domain\Dto;

class PerformedExchange
{
    private string $from;
    private string $to;
    private float $value;
    private float $convertedValue;
    private float $rate;

    public function __construct(string $from, string $to, float $value, float $convertedValue, float $rate)
    {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
        $this->convertedValue = $convertedValue;
        $this->rate = $rate;
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

    public function getConvertedValue(): float
    {
        return $this->convertedValue;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}