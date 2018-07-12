<?php

namespace FeeCalculator\Operation\Enum;

use FeeCalculator\Operation\Exceptions\EnumException;

/**
 * Class BaseEnum
 * @package FeeCalculator\Operation\Enum
 */
abstract class BaseEnum
{
    private static $constants;
    
    /**
     * @param $value
     *
     * @return bool
     * @throws EnumException
     */
    public static function isValid($value): bool
    {
        $values = array_values(self::getConstants());
        
        return \in_array($value, $values, $strict = true);
    }
    
    /**
     * @return mixed
     * @throws EnumException
     */
    private static function getConstants()
    {
        if (self::$constants === null) {
            self::$constants = [];
        }
        $calledClass = static::class;
        if (! array_key_exists($calledClass, self::$constants)) {
            try {
                $reflect = new \ReflectionClass($calledClass);
                self::$constants[$calledClass] = $reflect->getConstants();
            } catch (\ReflectionException $ex) {
                throw new EnumException($ex->getMessage());
            }
        }
        
        return self::$constants[$calledClass];
    }
}
