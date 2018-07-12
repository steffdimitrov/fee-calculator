<?php

namespace FeeCalculator\Contracts;

/**
 * Interface UserDetailsInterface
 * @package FeeCalculator\Contracts
 */
interface UserDetailsInterface
{
    /**
     * @return int
     */
    public function getIdentity(): int;
    
    /**
     * @return string
     */
    public function getType(): string;
}
