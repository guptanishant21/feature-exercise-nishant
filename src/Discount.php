<?php

namespace App;

class Discount
{
    /**
     * @var int
     */
    protected $threshold;

    /**
     * @var int
     */
    protected $amount;

    public function __construct(int $threshold, int $amount)
    {
        $this->threshold = $threshold;
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getThreshold() : int
    {
        return $this->threshold;
    }

    /**
     * @return int
     */
    public function getAmount() : int
    {
        return $this->amount;
    }
}
