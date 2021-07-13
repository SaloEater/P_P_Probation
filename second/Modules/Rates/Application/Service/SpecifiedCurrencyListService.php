<?php

namespace Modules\Rates\Application\Service;

use Modules\Core\Domain\Request\RequestInterface;
use Modules\Rates\Domain\Dto\SpecifiedCurrency;

class SpecifiedCurrencyListService
{
    private const CURRENCY_LIST_PARAM = 'currency';

    private RequestInterface $request;

    public function __construct(
        RequestInterface $request
    ) {
        $this->request = $request;
    }

    public function getList(): SpecifiedCurrency
    {
        return $this->getFromParam($this->request->getParams()[self::CURRENCY_LIST_PARAM] ?? '');
    }

    private function getFromParam(string $rawCurrencyList): SpecifiedCurrency
    {
        $list = $rawCurrencyList ? explode(',', $rawCurrencyList) : [];
        return new SpecifiedCurrency($list);
    }
}