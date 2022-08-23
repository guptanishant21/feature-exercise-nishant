<?php

namespace App;

interface CheckoutInterface
{
    /**
     * Adds an item to the checkout
     *
     * @param Product $product
     */
    public function scan(Product $product);

    /**
     * Calculates the total price of all items in this checkout
     *
     * @return int
     */
    public function total(): int;
}
