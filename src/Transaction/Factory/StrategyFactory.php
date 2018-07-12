<?php

namespace FeeCalculator\Transaction\Factory;

use FeeCalculator\Contracts\RateManagerInterface;
use FeeCalculator\Contracts\StrategyInterface;
use FeeCalculator\Transaction\Exception\InvalidTransactionTypeException;
use FeeCalculator\Transaction\Strategy\CashInStrategy;
use FeeCalculator\Transaction\Strategy\LegalCashOutStrategy;
use FeeCalculator\Transaction\Strategy\NaturalCashOutStrategy;

/**
 * Class StrategyFactory
 * @package FeeCalculator\Transaction\Factory
 */
class StrategyFactory
{
    /**
     * @param string $transactionType
     * @param RateManagerInterface $rateManager
     *
     * @return StrategyInterface
     */
    public function create(string $transactionType, RateManagerInterface $rateManager): StrategyInterface
    {
        switch ($transactionType) {
            case 'cash_in':
                return new CashInStrategy($rateManager);
            case 'cash_out_natural':
                return new NaturalCashOutStrategy($rateManager);
            case 'cash_out_legal':
                return new LegalCashOutStrategy($rateManager);
            default:
                throw new InvalidTransactionTypeException("Unknown transaction type '{$transactionType}'.");
        }
    }
}
