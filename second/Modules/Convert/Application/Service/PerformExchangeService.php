<?php

namespace Modules\Convert\Application\Service;

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
     * @return array
     * @throws
     */
    public function performExchange(Exchange $exchange): array
    {
        $this->validateExchangeService->validate($exchange);
        $performedExchange = $this->performExchangeService->performExchange($exchange);
        return (new Response($performedExchange))->toArray();
    }
}