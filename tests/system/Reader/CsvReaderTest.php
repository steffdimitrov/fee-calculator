<?php

namespace FeeCalculatorTests\system\Reader;

use FeeCalculator\Contracts\TransactionInterface;
use FeeCalculator\Reader\CsvReader;
use PHPUnit\Framework\TestCase;

/**
 * Class CsvReaderTest
 * @package FeeCalculatorTests\system\Reader
 */
class CsvReaderTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustReturnTransactionObjectsFromCSVFile()
    {
        $sut = new CsvReader(__DIR__ . '/../data/sample.csv');
        
        foreach ($sut->parse() as $transaction) {
            $this->assertInstanceOf(TransactionInterface::class, $transaction);
        }
    }
}
