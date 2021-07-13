<?php

use Modules\CommissionFee\Infrastructure\Service\EnviromentCommissionFeeService;
use Modules\Convert\Application\Contract\GetExchangeDtoFromRequestInterface;
use Modules\Convert\Application\Service\GetExchangeDtoFromRequestParamsService;
use Modules\Core\Domain\CommissionFee\CommissionFeeInterface;
use Modules\Core\Domain\Request\RequestInterface;
use Modules\Core\Infrastructure\Request\YiiRequestService;
use Modules\Rates\Domain\Storage\RatesStorageInterface;
use Modules\Rates\Infrastructure\Storage\InfoRatesStorageService;

return [
    'definitions' => [
        RequestInterface::class => YiiRequestService::class,
        CommissionFeeInterface::class => EnviromentCommissionFeeService::class,
        RatesStorageInterface::class => InfoRatesStorageService::class,
        GetExchangeDtoFromRequestInterface::class => GetExchangeDtoFromRequestParamsService::class,
    ],
];