<?php

namespace FeeCalculator\Contracts;

/**
 * Interface ReaderInterface
 * @package FeeCalculator\Contracts
 */
interface ReaderInterface
{
    /**
     * @return TransactionInterface
     */
    public function parse();
}
