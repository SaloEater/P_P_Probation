<?php

namespace Modules\Convert\Application\Contract;

use Modules\Convert\Domain\Dto\Exchange;

interface GetExchangeDtoFromRequestInterface
{
    /**
     * @return Exchange
     */
    public function getDto(): Exchange;
}