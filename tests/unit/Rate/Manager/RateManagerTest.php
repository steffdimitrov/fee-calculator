<?php

namespace FeeCalculatorTests\unit\Rate\Manager;

use FeeCalculator\Rate\Manager\RateManager;
use PHPUnit\Framework\TestCase;

/**
 * Class RateManagerTest
 * @package FeeCalculatorTests\unit\Rate\Manager
 */
class RateManagerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustConvertEURToUSD(): void
    {
        //Arrange
        $rateManager = new RateManager([
            'EUR' => [
                'USD' => 1.1497,
            ],
        ]);
        
        //Act
        $sut = $rateManager->convert('100', 'EUR', 'USD');
        
        //Assert
        $this->assertEquals(114.97, $sut);
    }
    
    public function testMustConvertEURToJPY(): void
    {
        //Arrange
        $rateManager = new RateManager([
            'EUR' => [
                'JPY' => 129.53,
            ],
            'JPY' => [
                'EUR' => 0.0077,
            ],
        ]);
        
        //Act
        $result = $rateManager->convert(100, 'EUR', 'JPY');
        
        //Assert
        $this->assertEquals(12953, $result);
        
        //Act
        $result = $rateManager->convert(1, 'JPY', 'EUR');
        
        //Assert
        $this->assertEquals(0.0077, $result);
    }
}
