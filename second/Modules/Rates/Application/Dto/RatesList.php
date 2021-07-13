<?php

namespace Modules\Rates\Application\Dto;

class RatesList
{
    /**
     * @var float[]
     */
    private array $ratesList = [];

    public function add(string $currency, float $rate): void
    {
        $this->ratesList[$currency] = $rate;
    }

    public function toArray(): array
    {
        return $this->ratesList;
    }

    public function sortAsc(): self
    {
        $copy = $this->ratesList;
        asort($copy);
        $copyList = new self();
        $copyList->ratesList = $copy;
        return $copyList;
    }
}