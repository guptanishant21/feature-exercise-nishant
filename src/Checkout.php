<?php

namespace App;

class Checkout implements CheckoutInterface
{
    /**
     * @var array $cart
     */
    protected $cart = [];

    /**
     * @var array $discounts
     */
    protected $discounts = [];

    /**
     * @var array
     */
    protected $statsItems = [];

    /**
     * Constructor function
     */
    public function __construct()
    {
        $this->statsItems = [
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
        ];

        /**
        * Discounts array (Threshold, Discounts)
        * @var array
        */
        $this->discounts = [
            'A' => [new Discount(3, 20)],
            'B' => [new Discount(2, 15)],
            'C' => [new Discount(3, 10), new Discount(2, 2)],
            // Case 'D' Covered below
        ];
    }

    /**
     * Adds an item to the checkout
     *
     * @param Product $product
     */
    public function scan(Product $product)
    {
        $this->statsItems[$product->getSku()]++;
        $this->cart[] = $product;
    }

    /**
     * Calculates the total price of all items in this checkout
     *
     * @return int
     */
    public function total(): int
    {
        $standardPrices = array_reduce($this->cart, function ($total, Product $product) {
            $total += $product->getPrice();
            return $total;
        }) ?? 0;
        
        $totalDiscount = $this->calculateDiscount();
        return $standardPrices - $totalDiscount;
    }

    /**
     * Calculate Discount Prices for items when quantity is more than threshold(Special Prices)
     * @return int
     */
    private function calculateDiscount()
    {
        $totalDiscount = 0;   
        foreach ($this->discounts as $key => $discount) {
            $a = $this->statsItems[$key];
            $index = 0;

            # For Case 'C'
            if ($key == 'C' && (array_key_exists("C",$this->statsItems) && ($this->statsItems['C'] > 0))) {
                while($index!=2) {
                    if ($a >= $discount[$index]->getThreshold()) {
                        $numberOfSets = floor($a / $discount[$index]->getThreshold());
                        $totalDiscount += ($discount[$index]->getAmount() * $numberOfSets);
                    }
                    $a = $a - $discount[$index]->getThreshold();
                    $index++;
                }}
                
                # For Case 'A' and 'B'
                else if ($a >= $discount[$index]->getThreshold()) {
                    $numberOfSets = floor($this->statsItems[$key] / $discount[$index]->getThreshold());
                    $totalDiscount += ($discount[$index]->getAmount() * $numberOfSets);
                }}

                # For case D
                if (((array_key_exists("D",$this->statsItems)) && ($this->statsItems['D'] > 0)) && ((array_key_exists("A",$this->statsItems)) && ($this->statsItems['A'] > 0))) {
                    $totalDiscount += 10;
                }
                return $totalDiscount;
            }
        }