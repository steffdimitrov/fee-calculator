<?php

namespace FeeCalculatorTests\system\Calculator\Manager;

use FeeCalculator\Calculator\Exception\StrategyManagerException;
use FeeCalculator\Calculator\Manager\CalculatorManager;
use FeeCalculator\Calculator\Manager\StrategyManager;
use FeeCalculator\Contracts\RateManagerInterface;
use FeeCalculator\Contracts\ReaderInterface;
use FeeCalculator\Currency\Manager\RoundManager;
use FeeCalculator\Rate\Manager\RateManager;
use FeeCalculator\Reader\CsvReader;
use FeeCalculator\Transaction\Factory\StrategyFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class CalculatorManagerTest
 * @package FeeCalculatorTests\unit\Calculator\Manager
 */
class CalculatorManagerTest extends TestCase
{
    /**
     * @var CalculatorManager
     */
    private $manager;
    
    public function setUp()
    {
        parent::setUp();
        
        $rateManager = $this->getRateManager();
        $strategyManager = $this->getStrategyManager();
        $roundManager = $this->getRoundManager();
        
        $this->manager = new CalculatorManager(
            $rateManager,
            $strategyManager,
            $roundManager
        );
    }
    
    public function testMustCalculateTransactionFee(): void
    {
        //Arrange
        $reader = $this->getReader();
        
        //Act
        $result = $this->manager->calculate($reader);
        
        //Assert
        $real = [0.06, 0.90, 0, 0.70, 0.30, 0.30, 5.00, 0.00, 0.00,];
        $this->assertEquals($real, $result);
    }
    
    /**
     * @@expectedException \FeeCalculator\Operation\Exceptions\EnumException
     * @@expectedExceptionMessage Invalid User type!
     */
    public function testMustThrowExceptionWhenInvalidUserTypeOccuresInDataStream()
    {
        //Arrange
        $reader = $this->getErrorReader();
    
        //Act
        $result = $this->manager->calculate($reader);
    }
    
    private function getRateManager(): RateManagerInterface
    {
        return new RateManager([
            'EUR' => [
                'USD' => 1.1497,
                'JPY' => 129.53,
            ],
            'JPY' => [
                'EUR' => 0.0077,
            ],
            'USD' => [
                'EUR' => 0.6680,
            ],
        ]);
    }
    
    private function getStrategyManager(): StrategyManager
    {
        $strategyFactory = new StrategyFactory();
        
        return new StrategyManager($strategyFactory);
    }
    
    private function getRoundManager(): RoundManager
    {
        return new RoundManager([
            'EUR' => 0.01,
            'JPY' => 1,
            'USD' => 0.01,
        ]);
    }
    
    private function getReader(): ReaderInterface
    {
        return new CsvReader(__DIR__ . '/../../data/sample.csv');
    }
    
    private function getErrorReader(): ReaderInterface
    {
        return new CsvReader(__DIR__ . '/../../data/fake.csv');
    }
}
