<?php

namespace Modules\Rates\Infrastructure\Storage;

use InvalidArgumentException;
use Modules\Rates\Domain\Dto\SpecifiedCurrency;
use Modules\Rates\Domain\Storage\RatesStorageInterface;
use Modules\Rates\Infrastructure\Dto\BlockchainInfoRatesList;

class InfoRatesStorageService implements RatesStorageInterface
{
    private const INFO_URL = 'https://blockchain.info/ticker';
    private const RATE_KEY = 'sell';

    private static BlockchainInfoRatesList $blockchainInfoRatesList;

    /**
     * @inheritDoc
     */
    public function get(string $currency): float
    {
        $this->ensureListExists();
        $rate = self::$blockchainInfoRatesList->get($currency);
        if ($rate == BlockchainInfoRatesList::INVALID_VALUE) {
            throw new InvalidArgumentException();
        }

        return $rate;
    }

    public function getCurrency(): SpecifiedCurrency
    {
        $this->ensureListExists();
        return new SpecifiedCurrency(array_keys(self::$blockchainInfoRatesList->toArray()));
    }

    private function ensureListExists()
    {
        if (!isset(self::$blockchainInfoRatesList)) {
            $this->initRatesList();
        }
    }

    private function initRatesList(): void
    {
        $json = file_get_contents(self::INFO_URL);
        $rates = json_decode($json, true);
        self::$blockchainInfoRatesList = new BlockchainInfoRatesList();
        foreach ($rates as $currency => $info) {
            self::$blockchainInfoRatesList->add($currency, $info[self::RATE_KEY]);
        }
    }
}