<?php

namespace FeeCalculatorTests;

use FeeCalculator\Contracts\RateManagerInterface;
use FeeCalculator\Contracts\TransactionDetailsInterface;
use FeeCalculator\Contracts\TransactionInterface;
use FeeCalculator\Contracts\UserDetailsInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseManagerTest
 * @package FeeCalculatorTests\unit\Calculator\Manager
 */
abstract class BaseManagerTest extends TestCase
{
    protected function getRateManagerMock()
    {
        $manager = $this->getMockBuilder(RateManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        return $manager;
    }
    
    protected function getTransactionMock(string $type, string $clientType)
    {
        $mock = $this->getMockBuilder(TransactionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $mock->method('getDetails')
            ->willReturn($this->getTransactionDetailsMock($type));
        
        $mock->method('getUserDetails')
            ->willReturn($this->getClientMock($clientType));
        
        return $mock;
    }
    
    protected function getTransactionDetailsMock(string $type)
    {
        $details = $this->getMockBuilder(TransactionDetailsInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $details->method('getType')
            ->willReturn($type);
        
        return $details;
    }
    
    protected function getClientMock(string $type)
    {
        $client = $this->getMockBuilder(UserDetailsInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $client->method('getType')
            ->willReturn($type);
        
        return $client;
    }
}
