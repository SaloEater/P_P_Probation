<?php

namespace Modules\Convert\Application\Service;

use Exception;
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

    /**
     * @return Exchange
     * @throws Exception
     */
    public function getDtoFromQuery(): Exchange
    {
        $params = $this->request->getQuery();
        return $this->getFromArray($params);
    }

    /**
     * @return Exchange
     * @throws Exception
     */
    public function getDtoFromBody(): Exchange
    {
        $params = $this->request->getPost();
        return $this->getFromArray($params);
    }

    private function getFromArray(array $params): Exchange
    {
        $from = $params[self::FROM_PARAM] ?? null;
        $to = $params[self::TO_PARAM] ?? null;
        $value = $params[self::VALUE_PARAM] ?? null;
        if (!$from || !$to || !$value) {
            throw new Exception();
        }
        return new Exchange($from, $to, $value);
    }
}