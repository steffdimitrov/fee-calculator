<?php

namespace FeeCalculator\Contracts;

/**
 * Interface StrategyInterface
 * @package FeeCalculator\Contracts
 */
interface StrategyInterface
{
    /**
     * @param TransactionInterface $transaction
     *
     * @return string
     */
    public function calculateCommission(TransactionInterface $transaction): string;
}
