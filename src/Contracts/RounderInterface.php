<?php

namespace FeeCalculator\Contracts;

/**
 * Interface RounderInterface
 * @package FeeCalculator\Contracts
 */
interface RounderInterface
{
    /**
     * @param string $value
     * @param string $currency
     *
     * @return string
     */
    public function round(string $value, string $currency): string;
}
