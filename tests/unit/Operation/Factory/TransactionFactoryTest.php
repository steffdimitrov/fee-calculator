<?php

namespace FeeCalculatorTests\unit\Operation\Factory;

use FeeCalculator\Operation\Factory\TransactionFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionFactoryTest
 * @package FeeCalculatorTests\unit\Operation\Factory
 */
class TransactionFactoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustBeInstanceOfTransactionFactory(): void
    {
        $this->assertInstanceOf(TransactionFactory::class, new TransactionFactory());
    }
    
    /**
     * @expectedException \FeeCalculator\Operation\Exceptions\EnumException
     * @expectedExceptionMessage Transaction type is invalid!
     */
    public function testMustThrowEnumExceptionForInvalidTransactionType(): void
    {
        $data = ['2016-01-05', 1, 'legal', 'cash_on', '200.00', 'EUR'];
        $sut = TransactionFactory::createTransaction($data);
    }
    
    /**
     * @expectedException \FeeCalculator\Operation\Exceptions\EnumException
     * @expectedExceptionMessage Currency is not supported!
     */
    public function testMustThrowEnumExceptionForInvalidCurrency(): void
    {
        $data = ['2016-01-05', 1, 'legal', 'cash_in', '200.00', 'BGN'];
        $sut = TransactionFactory::createTransaction($data);
    }
    
    /**
     * @expectedException \FeeCalculator\Operation\Exceptions\EnumException
     * @expectedExceptionMessage Invalid User type!
     */
    public function testMustThrowEnumExceptionForInvalidUserType(): void
    {
        $data = ['2016-01-05', 1, 'person', 'cash_in', '200.00', 'EUR'];
        $sut = TransactionFactory::createTransaction($data);
    }
}
