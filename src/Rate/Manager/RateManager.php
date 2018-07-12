<?php

namespace FeeCalculator\Rate\Manager;

use FeeCalculator\Calculator\Exception\RateException;
use FeeCalculator\Contracts\RateManagerInterface;

/**
 * Class RateManager
 * @package FeeCalculator\Rate\Manager
 */
class RateManager implements RateManagerInterface
{
    /**
     * @var array
     */
    private $rates = [];
    /**
     * @var int
     */
    private $scale;
    
    /**
     * Converter constructor.
     *
     * @param array $rates
     * @param int $scale
     */
    public function __construct(array $rates, int $scale = 4)
    {
        $this->scale = $scale;
        foreach ($rates as $from => $subrates) {
            foreach ($subrates as $to => $rate) {
                $this->rates[$from][$to] = $rate;
            }
        }
    }
    
    /**
     * @param string $amount
     * @param string $from
     * @param string $to
     *
     * @return string
     * @throws RateException
     */
    public function convert(string $amount, string $from, string $to): string
    {
        if ($from === $to || bccomp($amount, '0', $this->scale) === 0) {
            return $amount;
        }
        
        return bcmul($amount, $this->getRate($from, $to), $this->scale);
    }
    
    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     * @throws RateException
     */
    private function getRate(string $from, string $to): string
    {
        if (! isset($this->rates[$from][$to])) {
            throw new RateException('Rate from "' . $from . '"" to "' . $to . '" is missing!');
        }
        
        return $this->rates[$from][$to];
    }
}
