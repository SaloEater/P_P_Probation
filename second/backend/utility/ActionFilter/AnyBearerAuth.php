<?php

namespace backend\utility\ActionFilter;

use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

class AnyBearerAuth extends ActionFilter
{
    public string $header = 'Authorization';

    public string $pattern = '/^Bearer\s+(.*?)$/';

    /**
     * @inheritDoc
     */
    public function beforeAction($action): bool
    {
        $request = Yii::$app->getRequest();
        $bearerHeader = $request->getHeaders()->get($this->header);

        if ($bearerHeader !== null) {
            if ($this->pattern !== null) {
                if (preg_match($this->pattern, $bearerHeader, $matches)) {
                    return true;
                }
            }
        }

        throw new UnauthorizedHttpException();
    }
}