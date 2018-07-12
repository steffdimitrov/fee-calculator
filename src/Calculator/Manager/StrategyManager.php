<?php

namespace FeeCalculator\Calculator\Manager;

use FeeCalculator\Calculator\Exception\StrategyManagerException;
use FeeCalculator\Contracts\RateManagerInterface;
use FeeCalculator\Contracts\StrategyInterface;
use FeeCalculator\Contracts\TransactionInterface;
use FeeCalculator\Transaction\Factory\StrategyFactory;

/**
 * Class StrategyManager
 * @package FeeCalculator\Calculator\Manager
 */
class StrategyManager
{
    /**
     * @var StrategyFactory
     */
    private $factory;
    /**
     * @var StrategyInterface[]
     */
    private $strategies = [];
    
    /**
     * StrategyManager constructor.
     *
     * @param StrategyFactory $factory
     */
    public function __construct(StrategyFactory $factory)
    {
        $this->factory = $factory;
    }
    
    /**
     * @param TransactionInterface $transaction
     * @param RateManagerInterface $rateManager
     *
     * @return StrategyInterface
     * @throws StrategyManagerException
     */
    public function getStrategy(
        TransactionInterface $transaction,
        RateManagerInterface $rateManager
    ): StrategyInterface {
        $type = $transaction->getDetails()->getType();
        $userType = $transaction->getUserDetails()->getType();
        
        switch ($type) {
            case 'cash_in':
                $strategy = 'cash_in';
                break;
            case 'cash_out':
                switch ($userType) {
                    case 'natural':
                        $strategy = 'cash_out_natural';
                        break;
                    case 'legal':
                        $strategy = 'cash_out_legal';
                        break;
                    default:
                        throw new StrategyManagerException('Not implemented strategy: ' . $userType);
                }
                break;
            default:
                throw new StrategyManagerException('Not implemented strategy: ' . $type);
        }
        
        if (!isset($this->strategies[$strategy])) {
            $this->strategies[$strategy] = $this->factory->create($strategy, $rateManager);
        }
        
        return $this->strategies[$strategy];
    }
}
