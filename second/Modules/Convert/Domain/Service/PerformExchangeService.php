<?php

namespace Modules\Convert\Domain\Service;

use Exception;
use Modules\CommissionFee\Domain\Dto\CommissionedRate;
use Modules\Convert\Domain\Dto\Exchange;
use Modules\Convert\Domain\Dto\ExchangeDirection;
use Modules\Convert\Domain\Dto\PerformedExchange;
use Modules\Core\Domain\CommissionFee\CommissionFeeInterface;
use Modules\Rates\Domain\Storage\RatesStorageInterface;

class PerformExchangeService
{
    private const ROUND_FROM_BTC = 2;
    private const ROUND_TO_BTC = 10;

    private RatesStorageInterface $ratesStorage;
    private CommissionFeeInterface $commissionFee;

    public function __construct(
        RatesStorageInterface $ratesStorage,
        CommissionFeeInterface $commissionFee
    ) {
        $this->ratesStorage = $ratesStorage;
        $this->commissionFee = $commissionFee;
    }

    /**
     * @param Exchange $exchange
     * @return PerformedExchange
     * @throws Exception
     */
    public function performExchange(Exchange $exchange): PerformedExchange
    {
        $direction = $this->getDirection($exchange);
        $rate = $this->getRate($direction, $exchange);
        $commissionedRate = new CommissionedRate($this->commissionFee->getFee());
        $convertedValue = $commissionedRate->calculate($rate * $exchange->getValue());
        $convertedValue = $this->roundValue($direction, $convertedValue);
        return new PerformedExchange(
            $exchange->getFrom(),
            $exchange->getTo(),
            $exchange->getValue(),
            $convertedValue,
            $rate
        );
    }

    private function getDirection(Exchange $exchange): ExchangeDirection
    {
        $direction = new ExchangeDirection($exchange);
        if ($direction->isInvalid()) {
            throw new Exception();
        }
        return $direction;
    }

    private function getRate(ExchangeDirection $direction, Exchange $exchange): float
    {
        if ($direction->isFromBTC()) {
            return $this->getRateFromBTC($exchange->getTo());
        }
        return $this->getRateToBTC($exchange->getFrom());
    }

    private function getRateFromBTC(string $currency): float
    {
        return $this->ratesStorage->get($currency);
    }

    private function getRateToBTC(string $currency): float
    {
        return 1 / $this->ratesStorage->get($currency);
    }

    private function roundValue(ExchangeDirection $direction, float $convertedValue): float
    {
        if ($direction->isFromBTC()) {
            return round($convertedValue, self::ROUND_FROM_BTC);
        }

        return round($convertedValue, self::ROUND_TO_BTC);
    }
}