<?php

namespace Modules\CommissionFee\Infrastructure\Service;

use Modules\Core\Domain\CommissionFee\CommissionFeeInterface;

class EnviromentCommissionFeeService implements CommissionFeeInterface
{
    private const ENV_NAME = 'COMMISION_FEE';

    public function getFee(): float
    {
        return getenv(self::ENV_NAME) ?: 0;
    }
}