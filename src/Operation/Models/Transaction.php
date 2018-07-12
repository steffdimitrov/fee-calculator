<?php

namespace FeeCalculator\Operation\Models;

use FeeCalculator\Contracts\TransactionDetailsInterface;
use FeeCalculator\Contracts\TransactionInterface;
use FeeCalculator\Contracts\UserDetailsInterface;

/**
 * Class Transaction
 * @package FeeCalculator\Operation\Models\Operation
 */
class Transaction implements TransactionInterface
{
    /**
     * @var TransactionDetailsInterface
     */
    private $details;
    /**
     * @var UserDetailsInterface
     */
    private $userDetails;
    
    /**
     * Transaction constructor.
     *
     * @param TransactionDetailsInterface $details
     * @param UserDetailsInterface $userDetails
     */
    public function __construct(
        TransactionDetailsInterface $details,
        UserDetailsInterface $userDetails
    ) {
        $this->details = $details;
        $this->userDetails = $userDetails;
    }
    
    /**
     * @return TransactionDetailsInterface
     */
    public function getDetails(): TransactionDetailsInterface
    {
        return $this->details;
    }
    
    /**
     * @return UserDetailsInterface
     */
    public function getUserDetails(): UserDetailsInterface
    {
        return $this->userDetails;
    }
}
