<?php

/**
 * This Class is used to find the total price of products in given cart
 * This file can be run through command 'php index.php'
 *
 * PHP version 7.0
 *
 * @category   Sample Project
 * @package    StoreSample
 * @author     Vishal Varshney <vishalvarshney@outlook.in>
 * @version    1.0
 * @link       https://github.com/ivishalvarshney/StoreSampleCalculations
 * @since      File available since Release 1.0
 * @todo       Make compatible to run with browser also or we can make another
 *             version of this class
 */
class ShoppingCartPrice  {
    
    /**
     * This variable holds product price set defined by admin
     *
     * @var array
     */
    private $products;
    
    /**
     * This variable holds total price of products
     *
     * @var float
     */
    private $totalPrice;
    
    /**
     * This variable products from cart fetched from terminal
     *
     * @var array
     */
    private $productInCart;

    /**
     * This function read products(letters) from terminal 
     */
    function readProductsFromFile() {
        echo "Please enter the list of product and press enter : \n";
        $handle = fopen ("php://stdin","r"); // initiates the standard input
        $line   = fgets($handle); // returns a line from an open file
        $this->productInCart = strtoupper(rtrim($line)); // remove space & capitalize letters
    }
    
    /**
     * Get products and its count
     */
    function getProductsAndCount() {
        // split the string and convert into array
        $inputArray = str_split($this->productInCart, 1);
        
        //convert the input array into associative array having
        // item as key, and the number of item as value
        $this->products = array_count_values($inputArray);
    }
    
    /**
     * This function used to set product prices and group price
     * 
     * @return array
     */
    function setProductPrices() : array {
        //Product price array
        return  array(
            'A' => array('1'=>2.00, '4'=>7.00), // product price, group price
            'B' => array('1'=>12.00), 
            'C' => array('1'=>1.25, '6'=>6.00),
            'D' => array('1'=>0.15)
        );
    }
    
    /**
     * This function used to calculate total amount of products in cart
     */
    function calculateTotalAmount() {
        $products = $this->setProductPrices();
        foreach($this->products as $code=>$amount) {
            if(isset($products[$code]) && count($products[$code]) > 1) {
                $groupUnit = max(array_keys($products[$code]));
                $subtotal = intval($amount / $groupUnit) * $products[$code][$groupUnit] + fmod($amount, $groupUnit) * $products[$code]['1'];
                $this->totalPrice += $subtotal; 
            }
            elseif (isset($products[$code])) {
                $subtotal = $amount * $products[$code]['1'];
                $this->totalPrice += $subtotal;
            }
        }
    }
    
    /**
     * Get product prices and group price
     *
     * @todo currency symbol should come from locale/environment setting
     * 
     * @return string  total price with 2 places of decimal 
     */
    function getTotalPrices() : string {
         return '$'.number_format($this->totalPrice, 2); 
    }
}

//initalize new object of ShoppingCartPrice
$cart = new ShoppingCartPrice();

// reads product from terminal
$cart->readProductsFromFile();

// get products and its count
$cart->getProductsAndCount();

//calculate total amount of cart
$cart->calculateTotalAmount();

// print the result in dollar($)
echo $cart->getTotalPrices();

/**
 * EOC
 */

