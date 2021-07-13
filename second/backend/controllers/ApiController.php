<?php
namespace backend\controllers;

use backend\utility\ActionFilter\AnyBearerAuth;
use Modules\Convert\Application\Contract\GetExchangeDtoFromRequestInterface;
use Modules\Convert\Application\Service\PerformExchangeService;
use Modules\Rates\Application\Service\GetRatesList;
use Modules\Rates\Application\Service\SpecifiedCurrencyListService;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class ApiController extends Controller
{
    private SpecifiedCurrencyListService $specifiedCurrencyListService;
    private GetRatesList $getRatesList;
    private GetExchangeDtoFromRequestInterface $exchangeDtoFromRequest;
    private PerformExchangeService $performExchangeService;

    public function __construct(
        $id, $module,
        SpecifiedCurrencyListService $specifiedCurrencyListService,
        GetRatesList $getRatesList,
        GetExchangeDtoFromRequestInterface $exchangeDtoFromRequest,
        PerformExchangeService $performExchangeService,
        $config = []
    ) {
        $this->specifiedCurrencyListService = $specifiedCurrencyListService;
        $this->getRatesList = $getRatesList;
        $this->exchangeDtoFromRequest = $exchangeDtoFromRequest;
        $this->performExchangeService = $performExchangeService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            'class' => AnyBearerAuth::class,
        ];
    }

    public function actionIndex(string $method): object
    {
        if ($method == 'rates') {
            return $this->actionRates();
        } else {
            return $this->actionConvert();
        }
    }

    private function actionRates(): object
    {
        try {
            $specifiedCurrency = $this->specifiedCurrencyListService->getList();
            $list = $this->getRatesList->getList($specifiedCurrency);
            return $this->success($list->toArray());
        } catch (\Exception $e) {
            return $this->failure();
        }
    }

    private function actionConvert(): object
    {
        try {
            $exchange = $this->exchangeDtoFromRequest->getDto();
            $data = $this->performExchangeService->performExchange($exchange);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->failure();
        }
    }

    private function success($data): object
    {
        return \Yii::createObject([
            'class' => Response::class,
            'format' => Response::FORMAT_JSON,
            'data' => [
                'status' => 'success',
                'code' => 200,
                'data' => $data
            ]
        ]);
    }

    private function failure()
    {
        return \Yii::createObject([
            'class' => Response::class,
            'format' => Response::FORMAT_JSON,
            'data' => [
                'status' => 'error',
                'code' => 403,
                'data' => 'Invalid token'
            ]
        ]);
    }
}
