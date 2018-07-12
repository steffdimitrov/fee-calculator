<?php

namespace FeeCalculator\Transaction\Strategy;

use FeeCalculator\Contracts\RateManagerInterface;
use FeeCalculator\Contracts\TransactionInterface;

/**
 * Class BaseStrategy
 * @package FeeCalculator\Transaction\Strategy
 */
abstract class BaseStrategy
{
    /**
     * @var RateManagerInterface
     */
    protected $rateManager;
    /**
     * @var int
     */
    protected $scale;
    
    /**
     * BaseStrategy constructor.
     *
     * @param RateManagerInterface $rateManager
     * @param int $scale
     */
    public function __construct(RateManagerInterface $rateManager, int $scale = 4)
    {
        $this->rateManager = $rateManager;
        $this->scale = $scale;
    }
    
    /**
     * @param TransactionInterface $transaction
     *
     * @return string
     */
    abstract public function calculateCommission(TransactionInterface $transaction): string;
}
