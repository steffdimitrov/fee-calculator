<?php

namespace FeeCalculator\Contracts;

/**
 * Interface RateManagerInterface
 * @package FeeCalculator\Contracts
 */
interface RateManagerInterface
{
    /**
     * @param string $amount
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    public function convert(string $amount, string $from, string $to): string;
}
