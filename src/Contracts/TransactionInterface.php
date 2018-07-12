<?php

namespace FeeCalculator\Contracts;

/**
 * Interface TransactionInterface
 * @package FeeCalculator\Contracts
 */
interface TransactionInterface
{
    /**
     * @return TransactionDetailsInterface
     */
    public function getDetails(): TransactionDetailsInterface;
    
    /**
     * @return UserDetailsInterface
     */
    public function getUserDetails(): UserDetailsInterface;
}
