<?php

namespace FeeCalculator\Transaction\Strategy;

use FeeCalculator\Contracts\StrategyInterface;
use FeeCalculator\Contracts\TransactionInterface;

/**
 * Class CashInStrategy
 * @package FeeCalculator\Transaction\Strategy
 */
class CashInStrategy extends BaseStrategy implements StrategyInterface
{
    private const MAX_COMMISSION = '5.00';
    private const MAX_COMMISSION_CURRENCY = 'EUR';
    private const COMMISSION_RATE = '0.0003';
    
    /**
     * @param TransactionInterface $transaction
     *
     * @return string
     */
    public function calculateCommission(TransactionInterface $transaction): string
    {
        $details = $transaction->getDetails();
        $commission = bcmul(
            $details->getAmount(),
            self::COMMISSION_RATE,
            $this->scale
        );
        
        $max = $this->rateManager->convert(
            self::MAX_COMMISSION,
            self::MAX_COMMISSION_CURRENCY,
            $details->getCurrency()
        );
        
        return bccomp($commission, $max, $this->scale) === 1 ? $max : $commission;
    }
}
