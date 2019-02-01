<?php
namespace TDD\Test;
require 'vendor\autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;


//Luuakse ReceiptTest klass, sellele laienevad TestCase klassi väärtused
class ReceiptTest extends TestCase {
    public function setUp() {
        $this->Receipt = new Receipt();
    }

    public function tearDown() {
        unset($this->Receipt);
    }
    //total tähendus siin: public function total(array
    public function testTotal() {
        $input = [0,2,5,8];
        $output = $this->Receipt->total($input);
        $this->assertEquals(
            15,
            $output,
            'When summing the total should equal 15'
        );
    }

    public function testTax() {
        $inputAmount = 10.00;
        $taxInput = 0.10;
        $output = $this->Receipt->tax($inputAmount, $taxInput);
        $this->assertEquals(
            1.00,
            $output,
            'The tax calculation should equal 1.00'
            //kui kirjutada src/Resiept.php: public function tax($amount, $tax)
            //{
            //return $amount*$tax
            //}
        );
    }
}