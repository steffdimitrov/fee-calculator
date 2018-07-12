<?php

namespace FeeCalculatorTests\unit\Operation\Models;

use FeeCalculator\Contracts\TransactionDetailsInterface;
use FeeCalculator\Contracts\TransactionInterface;
use FeeCalculator\Contracts\UserDetailsInterface;
use FeeCalculator\Operation\Models\Transaction;
use FeeCalculator\Operation\Models\TransactionDetails;
use FeeCalculator\Operation\Models\UserDetails;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionTest
 * @package FeeCalculatorTests\unit\Operation\Models
 */
class TransactionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustReturnObjectOfTransactionInterface(): void
    {
        //Arrange
        $details = new TransactionDetails(new \DateTime(), 'cash_in', '200.00', 'EUR');
        $userDetails = new UserDetails(1, 'legal');
        
        //Act
        $sut = new Transaction($details, $userDetails);
        
        //Assert
        $this->assertInstanceOf(TransactionInterface::class, $sut);
        
        $this->assertInstanceOf(TransactionDetailsInterface::class, $sut->getDetails());
        $this->assertInstanceOf(UserDetailsInterface::class, $sut->getUserDetails());
    }
}
