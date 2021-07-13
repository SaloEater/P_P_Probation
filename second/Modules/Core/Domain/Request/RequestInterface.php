<?php

namespace Modules\Core\Domain\Request;

interface RequestInterface
{
    /**
     * @return array
     */
    public function getQuery(): array;

    /**
     * @return array
     */
    public function getPost(): array;
}