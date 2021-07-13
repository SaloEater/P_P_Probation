<?php

namespace Modules\CommissionFee\Domain\Dto;

class CommissionedRate
{
    private float $fee;

    public function __construct(float $fee)
    {
        $this->fee = $fee;
    }

    public function calculate(float $rate): float
    {
        return $rate * (1 - $this->fee);
    }
}