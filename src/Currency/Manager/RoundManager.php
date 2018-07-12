<?php

namespace FeeCalculator\Currency\Manager;

use FeeCalculator\Contracts\RounderInterface;
use FeeCalculator\Currency\Exception\PrecisionException;

/**
 * Class RoundManager
 * @package FeeCalculator\Currency\Manager
 */
class RoundManager implements RounderInterface
{
    /**
     * @var array
     */
    private $modifierByCurrency = [];
    /**
     * @var array
     */
    private $scaleByCurrency = [];
    /**
     * @var array
     */
    private $precisions = [];
    
    /**
     * RoundManager constructor.
     *
     * @param array $unitsByCurrency
     *
     * @throws PrecisionException
     */
    public function __construct(array $unitsByCurrency)
    {
        foreach ($unitsByCurrency as $currency => $precision) {
            if (! is_numeric($precision)) {
                throw new PrecisionException('Currency precision must be number!');
            }
        
            if ($precision > 1) {
                throw new PrecisionException('Currency precision must be less or equal to 1!');
            }
        
            $strUnit = (string)$precision;
        
            $scale = (\strlen($strUnit) - strrpos($strUnit, '.') - 1);
        
            $this->scaleByCurrency[$currency] = $scale;
            $this->modifierByCurrency[$currency] = 10 ** $scale;
        
            $this->precisions[$currency] = $precision;
        }
    }
    
    /**
     * @param string $value
     * @param string $currency
     *
     * @return string
     */
    public function round(string $value, string $currency): string
    {
        $rounded = $this->roundUp($value, $this->modifierByCurrency[$currency]);
        
        $scale = $this->scaleByCurrency[$currency];
        
        if (bccomp($rounded, '0', $scale) === 0) {
            return $this->format(0, $scale);
        }
        
        $rounded = $this->roundUpToUnit($rounded, $this->precisions[$currency]);
        
        return $this->format($rounded, $scale);
    }
    
    /**
     * @param string $value
     * @param int $scale
     *
     * @return string
     */
    private function format(string $value, int $scale): string
    {
        return sprintf("%.{$scale}f", $value);
    }
    
    /**
     * @param string $value
     * @param int $modifier
     *
     * @return string
     */
    private function roundUp(string $value, int $modifier): string
    {
        return (string)(ceil($value * $modifier) / $modifier);
    }
    
    /**
     * @param int $value
     * @param int $unit
     *
     * @return float
     */
    private function roundUpToUnit($value, $unit): float
    {
        if ($unit < 1) {
            return floor(($value + $unit / 2) / $unit) * $unit;
        }
        
        return ceil(($value + $unit / 2) / $unit) * $unit;
    }
}
