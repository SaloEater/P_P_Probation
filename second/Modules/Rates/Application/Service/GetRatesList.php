<?php

namespace Modules\Rates\Application\Service;

use Modules\CommissionFee\Domain\Dto\CommissionedRate;
use Modules\Core\Domain\CommissionFee\CommissionFeeInterface;
use Modules\Rates\Application\Dto\RatesList;
use Modules\Rates\Domain\Dto\SpecifiedCurrency;
use Modules\Rates\Domain\Storage\RatesStorageInterface;

class GetRatesList
{
    private RatesStorageInterface $blockchainRatesStorage;
    private CommissionFeeInterface $commissionFee;

    public function __construct(
        RatesStorageInterface $blockchainRatesStorage,
        CommissionFeeInterface $commissionFee
    ) {
        $this->blockchainRatesStorage = $blockchainRatesStorage;
        $this->commissionFee = $commissionFee;
    }

    public function getList(SpecifiedCurrency $specifiedCurrency): RatesList
    {
        $ratesList = new RatesList();

        if ($specifiedCurrency->isEmpty()) {
            $specifiedCurrency = $this->blockchainRatesStorage->getCurrency();
        }

        $commissionedRate = new CommissionedRate($this->commissionFee->getFee());
        foreach ($specifiedCurrency->get() as $currency) {
            $rate = $this->blockchainRatesStorage->get($currency);
            $ratesList->add($currency, $commissionedRate->calculate($rate));
        }

        return $ratesList->sortAsc();
    }
}