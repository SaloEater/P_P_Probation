<?php

namespace Modules\Convert\Application\Service;

use Modules\Convert\Application\Contract\GetExchangeDtoFromRequestInterface;
use Modules\Convert\Domain\Dto\Exchange;
use Modules\Core\Domain\Request\RequestInterface;

class GetExchangeDtoFromRequestParamsService implements GetExchangeDtoFromRequestInterface
{
    private const FROM_PARAM = 'currency_from';
    private const TO_PARAM = 'currency_to';
    private const VALUE_PARAM = 'value';

    private RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function getDto(): Exchange
    {
        $params = $this->request->getParams();
        $from = $params[self::FROM_PARAM] ?? null;
        $to = $params[self::TO_PARAM] ?? null;
        $value = $params[self::VALUE_PARAM] ?? null;
        if (!$from || !$to || !$value) {
            throw new \Exception();
        }
        return new Exchange($from, $to, $value);
    }
}