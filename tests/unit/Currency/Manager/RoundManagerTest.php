<?php

namespace FeeCalculatorTests\unit\Currency\Manager;

use FeeCalculator\Contracts\RounderInterface;
use FeeCalculator\Currency\Exception\PrecisionException;
use FeeCalculator\Currency\Manager\RoundManager;
use PHPUnit\Framework\TestCase;

/**
 * Class RoundManagerTest
 * @package FeeCalculatorTests\unit\Currency
 */
class RoundManagerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustBeInstanceOfRounderInterface(): void
    {
        //Arrange
        //Act
        $sut = new RoundManager(['EUR' => 0.05]);
        
        //Assert
        $this->assertInstanceOf(RounderInterface::class, $sut);
    }
    
    /**
     * @expectedException \FeeCalculator\Currency\Exception\PrecisionException
     * @expectedExceptionMessage Currency precision must be number!
     */
    public function testThrowPrecisionExceptionWhenPrecisionIsNotNumber(): void
    {
        //Arrange
        //Act
        $sut = new RoundManager(['EUR' => '0.05d']);
    }
    
    /**
     * @expectedException \FeeCalculator\Currency\Exception\PrecisionException
     * @expectedExceptionMessage Currency precision must be less or equal to 1
     */
    public function testThrowPrecisionExceptionWhenPrecisionBiggerThanOne(): void
    {
        //Arrange
        //Act
        $sut = new RoundManager(['EUR' => 6]);
    }
    
    public function testMustRoundNumbers()
    {
        //Arrange
        //Act
        $sut = new RoundManager(['EUR' => 0.01]);
        
        $this->assertEquals('11.13', $sut->round('11.123', 'EUR'));
        $this->assertEquals('0.03', $sut->round('0.023', 'EUR'));
    }
}
