<?php

namespace FeeCalculator\Operation\Factory;

use FeeCalculator\Contracts\TransactionDetailsInterface;
use FeeCalculator\Contracts\TransactionInterface;
use FeeCalculator\Contracts\UserDetailsInterface;
use FeeCalculator\Operation\Enum\UserTypeEnum;
use FeeCalculator\Operation\Models\Transaction;
use FeeCalculator\Operation\Enum\CurrencyEnum;
use FeeCalculator\Operation\Enum\TransactionTypeEnum;
use FeeCalculator\Operation\Exceptions\EnumException;
use FeeCalculator\Operation\Models\TransactionDetails;
use FeeCalculator\Operation\Models\UserDetails;

/**
 * Class TransactionFactory
 * @package FeeCalculator\Operation\Factory
 */
class TransactionFactory
{
    /**
     * @param array $data
     *
     * @return TransactionInterface
     * @throws EnumException
     * @throws \ReflectionException
     */
    public static function createTransaction(array $data): TransactionInterface
    {
        $details = self::createTransactionDetails($data);
        
        $userDetails = self::createUserDetails($data);
        
        return new Transaction($details, $userDetails);
    }
    
    /**
     * @param array $data
     *
     * @return TransactionDetailsInterface
     * @throws EnumException
     * @throws \ReflectionException
     */
    private static function createTransactionDetails(array $data): TransactionDetailsInterface
    {
        $date = new \DateTime($data[0]);
        if (!TransactionTypeEnum::isValid($data[3])) {
            throw new EnumException('Transaction type is invalid!');
        }
        
        $type = $data[3];
        $amount = $data[4];
    
        if (!CurrencyEnum::isValid($data[5])) {
            throw new EnumException('Currency is not supported!');
        }
        
        $currency = $data[5];
        
        return new TransactionDetails($date, $type, $amount, $currency);
    }
    
    /**
     * @param array $data
     *
     * @return UserDetailsInterface
     * @throws EnumException
     * @throws \ReflectionException
     */
    private static function createUserDetails(array $data): UserDetailsInterface
    {
        $id = $data[1];
    
        if (!UserTypeEnum::isValid($data[2])) {
            throw new EnumException('Invalid User type!');
        }
        $type = $data[2];
        
        return new UserDetails($id, $type);
    }
}
