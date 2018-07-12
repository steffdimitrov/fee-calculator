<?php

namespace FeeCalculator\Contracts;

/**
 * Interface TransactionDetailsInterface
 * @package FeeCalculator\Contracts
 */
interface TransactionDetailsInterface
{
    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime;
    
    /**
     * @return string
     */
    public function getType(): string;
    
    /**
     * @return string
     */
    public function getAmount(): string;
    
    /**
     * @return string
     */
    public function getCurrency(): string;
}
