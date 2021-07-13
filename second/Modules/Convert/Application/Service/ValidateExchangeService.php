<?php

namespace Modules\Convert\Application\Service;

use Exception;
use Modules\Convert\Domain\Dto\Exchange;
use Modules\Convert\Domain\Dto\ExchangeDirection;
use Modules\Core\Domain\Dto\CurrencyName;

class ValidateExchangeService
{
    /**
     * @param Exchange $exchange
     * @throws
     */
    public function validate(Exchange $exchange): void
    {
        $direction = $this->getDirection($exchange);
        $this->validateBTCCurrencyPresence($exchange);
        $this->validateBTCCurrencyOnlyOne($exchange);
        if ($direction->isToBTC()) {
            $this->validateFromPrecision($exchange);
        }
    }

    private function validateBTCCurrencyPresence(Exchange $exchange): void
    {
        if (!in_array(CurrencyName::BTC, [$exchange->getTo(), $exchange->getFrom()])) {
            throw new Exception();
        }
    }

    private function validateBTCCurrencyOnlyOne(Exchange $exchange): void
    {
        if ($exchange->getTo() == CurrencyName::BTC && $exchange->getFrom() == CurrencyName::BTC) {
            throw new Exception();
        }
    }

    private function validateFromPrecision(Exchange $exchange): void
    {
        if ($exchange->getValue() < 0.01) {
            throw new Exception();
        }
    }

    private function getDirection(Exchange $exchange): ExchangeDirection
    {
        $direction = new ExchangeDirection($exchange);
        if ($direction->isInvalid()) {
            throw new Exception();
        }
        return $direction;
    }
}