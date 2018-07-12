<?php

namespace FeeCalculator\Operation\Models;

use FeeCalculator\Contracts\TransactionDetailsInterface;

/**
 * Class TransactionDetails
 * @package FeeCalculator\Operation\Models
 */
class TransactionDetails implements TransactionDetailsInterface
{
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $amount;
    /**
     * @var string
     */
    private $currency;
    
    /**
     * Transaction constructor.
     *
     * @param \DateTime $date
     * @param string $type
     * @param string $amount
     * @param string $currency
     */
    public function __construct(\DateTime $date, string $type, string $amount, string $currency)
    {
        $this->date = $date;
        $this->type = $type;
        $this->amount = $amount;
        $this->currency = $currency;
    }
    
    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }
    
    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
