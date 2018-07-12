<?php

namespace FeeCalculatorTests\unit\Operation\Models;

use FeeCalculator\Contracts\UserDetailsInterface;
use FeeCalculator\Operation\Models\UserDetails;
use PHPUnit\Framework\TestCase;

/**
 * Class UserDetailsTest
 * @package FeeCalculatorTests\unit\Operation\Models
 */
class UserDetailsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustBeInstanceOfUserDetailsInterface(): void
    {
        $this->assertInstanceOf(UserDetailsInterface::class, new UserDetails(1, ''));
    }
    
    public function testMustReturnUserDetails(): void
    {
        //Arrange
        //Act
        $sut = new UserDetails(1, 'legal');
        
        //Assert
        $this->assertEquals(1, $sut->getIdentity());
        $this->assertEquals('legal', $sut->getType());
    }
}
