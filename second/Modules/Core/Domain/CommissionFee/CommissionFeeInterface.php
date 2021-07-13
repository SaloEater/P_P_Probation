<?php

namespace Modules\Core\Domain\CommissionFee;

interface CommissionFeeInterface
{
    /**
     * @return float
     */
    public function getFee(): float;
}