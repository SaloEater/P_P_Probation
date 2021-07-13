<?php

namespace Modules\Convert\Domain\Dto;

use Modules\Core\Domain\Dto\CurrencyName;

class ExchangeDirection
{
    private const DIR_FROM_BTC = 0;
    private const DIR_TO_BTC = 1;
    private const INVALID_DIR = -1;

    private int $dir;

    public function __construct(Exchange $exchange)
    {
        if ($exchange->getFrom() == CurrencyName::BTC) {
            $this->dir = self::DIR_FROM_BTC;
        } else if ($exchange->getTo() == CurrencyName::BTC) {
            $this->dir = self::DIR_TO_BTC;
        } else {
            $this->dir = self::INVALID_DIR;
        }
    }

    public function isFromBTC(): bool
    {
        return $this->dir == self::DIR_FROM_BTC;
    }

    public function isToBTC(): bool
    {
        return $this->dir == self::DIR_TO_BTC;
    }

    public function isInvalid(): bool
    {
        return $this->dir == self::INVALID_DIR;
    }
}