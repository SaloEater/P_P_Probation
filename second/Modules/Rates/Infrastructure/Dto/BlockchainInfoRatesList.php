<?php

namespace Modules\Rates\Infrastructure\Dto;

class BlockchainInfoRatesList
{
    public const INVALID_VALUE = -1;

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

    /**
     * @param string $currency
     * @return float
     */
    public function get(string $currency): float
    {
        return array_key_exists($currency, $this->ratesList)
            ? $this->ratesList[$currency]
            : self::INVALID_VALUE;
    }
}