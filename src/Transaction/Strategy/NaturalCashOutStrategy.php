<?php

namespace FeeCalculator\Transaction\Strategy;

use FeeCalculator\Contracts\StrategyInterface;
use FeeCalculator\Contracts\TransactionInterface;

/**
 * Class NaturalCashOutStrategy
 * @package FeeCalculator\Transaction\Strategy
 */
class NaturalCashOutStrategy extends BaseStrategy implements StrategyInterface
{
    private const COMMISSION_RATE = '0.003';
    private const MAX_DISCOUNT_OPERATIONS = 3;
    private const MAX_DISCOUNT_SUM = '1000.00';
    private const DISCOUNT_CURRENCY = 'EUR';
    /**
     * @var int
     */
    private $period;
    /**
     * @var array
     */
    private $periodTotals = [];
    
    /**
     * @param TransactionInterface $transaction
     *
     * @return string
     */
    public function calculateCommission(TransactionInterface $transaction): string
    {
        $details = $transaction->getDetails();
        $this->setCurrentPeriod($details->getDate());
        
        $clientId = $transaction->getUserDetails()->getIdentity();
        
        $amount = $details->getAmount();
        $currency = $details->getCurrency();
        
        $commission = $this->getCommission(
            $amount,
            $currency,
            $this->getPeriodOperationCount($clientId),
            $this->getPeriodOperationSum($clientId)
        );
        
        $this->addPeriodOperation($clientId, $amount, $currency);
        
        return bcmul($commission, self::COMMISSION_RATE, $this->scale);
    }
    
    /**
     * @param string $amount
     * @param string $currency
     * @param int $periodOperationCount
     * @param string $periodOperationSum
     *
     * @return string
     */
    private function getCommission(string $amount, string $currency, int $periodOperationCount, string $periodOperationSum): string
    {
        if ($periodOperationCount > self::MAX_DISCOUNT_OPERATIONS) {
            return $amount;
        }
        
        $remainingDiscount = bcsub(
            self::MAX_DISCOUNT_SUM,
            $periodOperationSum,
            $this->scale
        );
        
        if (bccomp($remainingDiscount, '0', $this->scale) < 1) {
            return $amount;
        }
        $remainingDiscountConverted = $this->rateManager->convert(
            $remainingDiscount,
            self::DISCOUNT_CURRENCY,
            $currency
        );
        
        $fee = bcsub($amount, $remainingDiscountConverted, $this->scale);
        
        return bccomp($fee, '0', $this->scale) === 1 ? $fee : '0';
    }
    
    /**
     * @param int $clientId
     *
     * @return int
     */
    private function getPeriodOperationCount(int $clientId): int
    {
        return $this->periodTotals[$clientId]->count ?? 0;
    }
    
    /**
     * @param int $clientId
     *
     * @return string
     */
    private function getPeriodOperationSum(int $clientId): string
    {
        return $this->periodTotals[$clientId]->sum ?? '0';
    }
    
    /**
     * @param int $clientId
     * @param string $amount
     * @param string $currency
     *
     * @return void
     */
    private function addPeriodOperation(int $clientId, string $amount, string $currency): void
    {
        $clientTotals = $this->periodTotals[$clientId] ?? new \stdClass();
        
        $clientTotals->count = ($clientTotals->count ?? 0) + 1;
        
        $convertedSum = $this->rateManager->convert($amount, $currency, self::DISCOUNT_CURRENCY);
        $clientTotals->sum = bcadd($clientTotals->sum ?? '0.00', $convertedSum, $this->scale);
        
        $this->periodTotals[$clientId] = $clientTotals;
    }
    
    /**
     * @param \DateTime $date
     *
     * @return void
     */
    private function setCurrentPeriod(\DateTime $date): void
    {
        $period = $date->format('W');
        
        if ($period !== $this->period) {
            $this->period = $period;
            $this->periodTotals = [];
        }
    }
}
