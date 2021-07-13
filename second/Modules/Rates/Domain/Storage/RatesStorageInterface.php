<?php

namespace Modules\Rates\Domain\Storage;

use Modules\Rates\Domain\Dto\SpecifiedCurrency;

interface RatesStorageInterface
{
    /**
     * @param string $currency
     * @return float
     * @throws
     */
    public function get(string $currency): float;

    /**
     * @return SpecifiedCurrency
     */
    public function getCurrency(): SpecifiedCurrency;
}