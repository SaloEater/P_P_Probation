<?php

namespace Modules\Core\Infrastructure\Request;

use Modules\Core\Domain\Request\RequestInterface;
use Yii;

class YiiRequestService implements RequestInterface
{
    /**
     * @inheritDoc
     */
    public function getParams(): array
    {
        return Yii::$app->request->get() ?? [];
    }
}