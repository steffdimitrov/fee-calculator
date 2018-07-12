<?php

namespace FeeCalculatorTests\unit\Calculator\Manager;

use FeeCalculator\Calculator\Manager\StrategyManager;
use FeeCalculator\Transaction\Factory\StrategyFactory;
use FeeCalculator\Transaction\Strategy\CashInStrategy;
use FeeCalculator\Transaction\Strategy\LegalCashOutStrategy;
use FeeCalculator\Transaction\Strategy\NaturalCashOutStrategy;
use FeeCalculatorTests\BaseManagerTest;

/**
 * Class StrategyManagerTest
 * @package FeeCalculatorTests\unit\Calculator\Manager
 */
class StrategyManagerTest extends BaseManagerTest
{
    /**
     * @var StrategyManager
     */
    private $manager;
    
    public function setUp()
    {
        parent::setUp();
        
        //Arrange
        $strategyFactory = new StrategyFactory();
        $this->manager = new StrategyManager($strategyFactory);
    }
    
    public function testMustGetStrategyForCashInTransactions(): void
    {
        //Arrange
        $transaction = $this->getTransactionMock('cash_in', 'natural');
        $rateManager = $this->getRateManagerMock();
        
        //Act
        $strategy = $this->manager->getStrategy($transaction, $rateManager);
        
        //Assert
        $this->assertEquals(CashInStrategy::class, \get_class($strategy));
    }
    
    public function testMustGetStrategyForNaturalCashOutTransactions(): void
    {
        //Arrange
        $transaction = $this->getTransactionMock('cash_out', 'natural');
        $rateManager = $this->getRateManagerMock();
        
        //Act
        $strategy = $this->manager->getStrategy($transaction, $rateManager);
        
        //Assert
        $this->assertEquals(NaturalCashOutStrategy::class, \get_class($strategy));
    }
    
    public function testMustGetStrategyForLegalCashOutTransactions(): void
    {
        //Arrange
        $transaction = $this->getTransactionMock('cash_out', 'legal');
        $rateManager = $this->getRateManagerMock();
        
        //Act
        $strategy = $this->manager->getStrategy($transaction, $rateManager);
        
        //Assert
        $this->assertEquals(LegalCashOutStrategy::class, \get_class($strategy));
    }
}
