<?php

namespace FeeCalculator\Calculator\Manager;

use FeeCalculator\Contracts\ReaderInterface;
use FeeCalculator\Contracts\RateManagerInterface;
use FeeCalculator\Contracts\TransactionDetailsInterface;
use FeeCalculator\Currency\Manager\RoundManager;

/**
 * Class CalculatorManager
 * @package FeeCalculator\Calculator\Manager
 */
class CalculatorManager
{
    /**
     * @var RateManagerInterface
     */
    private $rateManager;
    /**
     * @var StrategyManager
     */
    private $strategyManager;
    /**
     * @var RoundManager
     */
    private $roundManager;
    
    /**
     * CalculatorManager constructor.
     *
     * @param RateManagerInterface $rateManager
     * @param StrategyManager $strategyManager
     * @param RoundManager $roundManager
     */
    public function __construct(
        RateManagerInterface $rateManager,
        StrategyManager $strategyManager,
        RoundManager $roundManager
    ) {
        $this->rateManager = $rateManager;
        $this->strategyManager = $strategyManager;
        $this->roundManager = $roundManager;
    }
    
    /**
     * @param ReaderInterface $reader
     *
     * @return array
     * @throws \FeeCalculator\Calculator\Exception\StrategyManagerException
     */
    public function calculate(ReaderInterface $reader): array
    {
        $result = [];
        foreach ($reader->parse() as $transaction) {
            $strategy = $this->strategyManager->getStrategy(
                $transaction,
                $this->rateManager
            );
            
            $commission = $strategy->calculateCommission($transaction);
        
            /** @var TransactionDetailsInterface $details */
            $details = $transaction->getDetails();
            $result[] = $this->roundManager->round($commission, $details->getCurrency());
        }
        
        return $result;
    }
}
