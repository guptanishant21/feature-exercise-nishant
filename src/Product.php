<?php

namespace App;

class Product implements ProductInterface
{
    /**
     * @var string
     */
    protected $sku;

    /**
     * @var int
     */
    protected $price;

    public function __construct(string $sku, int $price)
    {
        $this->sku = $sku;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * @return int
     */
    public function getPrice() : int
    {
        return $this->price;
    }
}
