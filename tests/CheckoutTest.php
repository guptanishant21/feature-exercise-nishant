<?php

namespace Tests;

use App\Checkout;
use App\Product;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
     /**
     * Test case function for testing the implementations of case 'A'
     */
     public function test_scanning_sku_a_returns_total_of_50()
     {
        $checkout = new Checkout();
        $checkout->scan(new Product('A', 50));
        $this->assertEquals(50, $checkout->total(), 'Checkout total does not equal expected value of 50');
    }

    /**
     * Test case function for testing empty cart
    */
    public function test_an_empty_checkout_returns_a_total_of_zero()
    {
        $checkout = new Checkout();
        $this->assertEquals(0, $checkout->total(), 'Checkout total does not equal expected value of 0');
    }

    /**
     * Test case function for testing the implementations of case two 'B'
    */
    public function test_the_price_is_discounted_when_ordering_two_times_b()
    {
        $checkout = new Checkout();
        $product_b = new Product('B', 30);
        $checkout->scan($product_b);
        $checkout->scan($product_b);
        $this->assertEquals(45, $checkout->total(), 'Checkout total does not equal expected value of 45');
    }

    /**
     * Test case function for tetsing the main implementations of the code for all items ('A','B','C','D') 
     * @dataProvider basketProvider
    */
    public function test_scanning_multiple_skus_returns_the_expected_totals($expectedTotal, $itemsToAdd)
    {
        $checkout = new Checkout();
        array_map(function (Product $product) use ($checkout) {

            $checkout->scan($product);
        }, $itemsToAdd);

        $this->assertEquals(
            $expectedTotal,
            $checkout->total(),
            'Checkout total does not equal expected value of ' . $expectedTotal
        );
    }

    # This is to take care of main test cases
    public function basketProvider()
    {
        $product_a = new Product('A', 50);
        $product_b = new Product('B', 30);
        $product_c = new Product('C', 20);
        $product_d = new Product('D', 15);

        return [
            [
                130,
                [$product_a, $product_a, $product_a]
            ],
            [
                45,
                [$product_b, $product_b]
            ],
            [
                55,
                [$product_a, $product_d]
            ],
            [
                135,
                [$product_a, $product_a, $product_a, $product_d]
            ],
            [
                130,
                [$product_a, $product_b, $product_a]
            ],
            [
                70,
                [$product_c, $product_c, $product_c, $product_c]
            ],
            [
                88,
                [$product_c, $product_c, $product_c, $product_c, $product_c]
            ],
        ];
    }
}