<?php

namespace Modules\Rates\Domain\Dto;

class SpecifiedCurrency
{
    /**
     * @var string[]
     */
    private array $specifiedCurrency;

    public function __construct(array $specifiedCurrency = [])
    {
        $this->specifiedCurrency = $specifiedCurrency;
    }

    public function add(string $currency): self
    {
        if (!in_array($currency, $this->specifiedCurrency)) {
            $copy = $this->specifiedCurrency;
            $copy[] = $currency;
            return new self($copy);
        }
        return $this;
    }

    public function get(): array
    {
        return $this->specifiedCurrency;
    }

    public function isEmpty(): bool
    {
        return empty($this->specifiedCurrency);
    }
}