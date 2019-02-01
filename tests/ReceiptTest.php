<?php
namespace TDD\Test;
require 'vendor\autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;



class ReceiptTest extends TestCase { //Luuakse ReceiptTest klass, sellele laienevad TestCase klassi väärtused

    public function setUp() { // laiendab TestCase klassi, pannakse tööle enne testmeetodite käivitamist, seal tehakse testimiseks vajalikud ettevalmistused
        $this->Receipt = new Receipt(); // luuakse uus objekt nimega Receipt
    }
//Dummy object
    public function tearDown() {
        unset($this->Receipt); //objekt $Receipt kustutatakse mälust
    }
    public function testTotal($items, $expected) { //
        $coupon = null; // muutuja on väärtuseta
        $output = $this->Receipt->total($items, $coupon); // kutsutakse välja total meetod ja annab ette items-i ja coupon-i
        $this->assertEquals( // veendu et võrdub
            $expected, //
            $output, // see mis tuleb reaalselt
            'When summing the total should equal {$expected}' // teade tuleb vea korral
        );
    }

    public function testTax() {
        $inputAmount = 10.00; // sisendväärtus
        $taxInput = 0.10; // kasu sisend
        $output = $this->Receipt->tax($inputAmount, $taxInput); // muutuja ja kutsume muutuja tax
        $this->assertEquals( // veendu et võrdub
            1.00, // oodatav tulemus
            $output, // see mis tuleb reaalselt
            //kui kirjutada src/Resiept.php: public function tax($amount, $tax)return $amount*$tax
            'The tax calculation should equal 1.00' // teade tuleb vea korral
        );
    }
}
