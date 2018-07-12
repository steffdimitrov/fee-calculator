<?php

namespace FeeCalculator\Operation\Models;

use FeeCalculator\Contracts\UserDetailsInterface;

/**
 * Class UserDetails
 * @package FeeCalculator\Operation\Models
 */
class UserDetails implements UserDetailsInterface
{
    /**
     * @var int
     */
    private $identity;
    /**
     * @var string
     */
    private $type;
    
    /**
     * UserDetails constructor.
     *
     * @param int $identity
     * @param string $type
     */
    public function __construct(int $identity, string $type)
    {
        $this->identity = $identity;
        $this->type = $type;
    }
    
    /**
     * @return int
     */
    public function getIdentity(): int
    {
        return $this->identity;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
