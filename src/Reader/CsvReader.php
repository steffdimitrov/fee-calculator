<?php

namespace FeeCalculator\Reader;

use FeeCalculator\Contracts\ReaderInterface;
use FeeCalculator\Contracts\TransactionInterface;
use FeeCalculator\Operation\Factory\TransactionFactory;

/**
 * Class CsvReader
 * @package FeeCalculator\Reader
 */
class CsvReader implements ReaderInterface
{
    private const READ_MODE = 'rb';
    private const CHUNK = 4096;
    /**
     * @var bool|resource
     */
    private $file;
    
    /**
     * CsvReader constructor.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = fopen($file, self::READ_MODE);
    }
    
    /**
     * Generators in PHP doesn't support return type different then \Generator
     * But here we are yielding TransactionInterface objects
     *
     * @return TransactionInterface|\Generator
     * @throws \FeeCalculator\Operation\Exceptions\EnumException
     * @throws \ReflectionException
     */
    public function parse()
    {
        while (! feof($this->file)) {
            $row = array_map('trim', (array)fgetcsv($this->file, self::CHUNK));
            
            yield TransactionFactory::createTransaction($row);
        }
    }
}
