<?php

namespace Modules\Convert\Application\Dto;

use Modules\Convert\Domain\Dto\PerformedExchange;

class Response
{
    private string $from;
    private string $to;
    private float $value;
    private float $convertedValue;
    private float $rate;

    public function __construct(PerformedExchange $performedExchange)
    {
        $this->from = $performedExchange->getFrom();
        $this->to = $performedExchange->getTo();
        $this->value = $performedExchange->getValue();
        $this->convertedValue = $performedExchange->getConvertedValue();
        $this->rate = $performedExchange->getRate();
    }

    public function toArray(): array
    {
        return [
            'currency_from' => $this->from,
            'currency_to' => $this->to,
            'value' => $this->f2s($this->value),
            'converted_value' => $this->f2s($this->convertedValue),
            'rate' => $this->f2s($this->rate),
        ];
    }

    private function f2s(float $f) {
        $s = (string)$f;
        if (!strpos($s,"E")) return $s;
        list($be,$ae)= explode("E",$s);
        $fs = "%.".(string)(strlen(explode(".",$be)[1])+(abs($ae)-1))."f";
        return sprintf($fs,$f);
    }
}