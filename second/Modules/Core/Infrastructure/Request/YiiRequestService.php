<?php

namespace Modules\Core\Infrastructure\Request;

use Modules\Core\Domain\Request\RequestInterface;
use Yii;

class YiiRequestService implements RequestInterface
{
    /**
     * @inheritDoc
     */
    public function getQuery(): array
    {
        return Yii::$app->request->get() ?? [];
    }

    public function getPost(): array
    {
        return Yii::$app->request->post() ?? [];
    }
}