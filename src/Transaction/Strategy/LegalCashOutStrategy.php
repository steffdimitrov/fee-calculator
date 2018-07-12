<?php

namespace FeeCalculator\Transaction\Strategy;

use FeeCalculator\Contracts\StrategyInterface;
use FeeCalculator\Contracts\TransactionInterface;

/**
 * Class LegalCashOutStrategy
 * @package FeeCalculator\Transaction\Strategy
 */
class LegalCashOutStrategy extends BaseStrategy implements StrategyInterface
{
    private const MIN_COMMISSION = '0.50';
    private const MIN_COMMISSION_CURRENCY = 'EUR';
    private const COMMISSION_RATE = '0.003';
    
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
        $minCommission = $this->rateManager->convert(
            self::MIN_COMMISSION,
            self::MIN_COMMISSION_CURRENCY,
            $details->getCurrency()
        );
        
        return bccomp(
            $commission,
            $minCommission,
            $this->scale
        ) === 1 ? $commission : $minCommission;
    }
}
