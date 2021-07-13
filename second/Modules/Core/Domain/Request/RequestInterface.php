<?php

namespace Modules\Core\Domain\Request;

interface RequestInterface
{
    /**
     * @return array
     */
    public function getParams(): array;
}