<?php

namespace FeeCalculatorTests\unit\Operation\Models;

use FeeCalculator\Operation\Models\Transaction;
use FeeCalculator\Operation\Models\TransactionDetails;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionDetailsTest
 * @package FeeCalculatorTests\unit\Operation\Models
 */
class TransactionDetailsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustGetTransactionProperties(): void
    {
        //Arrange
        $date = new \DateTime('2016-10-10');
        
        //Act
        $sut = new TransactionDetails($date, 'cash_in', '200.00', 'EUR');
        
        //Assert
        $this->assertEquals($date->format('Y-m-d'), $sut->getDate()->format('Y-m-d'));
        $this->assertEquals('cash_in', $sut->getType());
        $this->assertEquals('200.00', $sut->getAmount());
        $this->assertEquals('EUR', $sut->getCurrency());
    }
}
