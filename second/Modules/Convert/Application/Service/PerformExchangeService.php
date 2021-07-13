<?php

namespace Modules\Convert\Application\Service;

use Exception;
use Modules\Convert\Application\Dto\Response;
use Modules\Convert\Domain\Dto\Exchange;
use Modules\Convert\Domain\Service\PerformExchangeService as DomainPerformExchangeService;

class PerformExchangeService
{
    private DomainPerformExchangeService $performExchangeService;
    private ValidateExchangeService $validateExchangeService;

    public function __construct(
        DomainPerformExchangeService $performExchangeService,
        ValidateExchangeService $validateExchangeService
    ) {
        $this->performExchangeService = $performExchangeService;
        $this->validateExchangeService = $validateExchangeService;
    }

    /**
     * @param Exchange $exchange
     * @return Response
     * @throws Exception
     */
    public function performExchange(Exchange $exchange): Response
    {
        $this->validateExchangeService->validate($exchange);
        $performedExchange = $this->performExchangeService->performExchange($exchange);
        return new Response($performedExchange);
    }
}