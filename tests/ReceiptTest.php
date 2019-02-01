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

public function provideTotal() { // andme edastus funktsioon koos etteantud väärtustega
    return [
        'ints totaling 16' => [[1,2,5,8], 16], // kokku 16
        [[-1,2,5,8], 14], // kokku 14
        [[1,2,8], 11], // kokku 11
    ];
}
    public function provideTotal() { // andme edastus funktsioon koos etteantud väärtustega
        return [
            'ints totaling 16' => [[1,2,5,8], 16], // kokku 16
            [[-1,2,5,8], 14], // kokku 14
            [[1,2,8], 11], // kokku 11
        ];
    }
    // uus funktsioon "testTotalAndCoupon", aga koos coupon-i väärtusega
    public function testTotalAndCoupon() {
        $input = [0,2,5,8];
        $coupon = 0.20; // nüüd on väärtus olemas
        $output = $this->Receipt->total($input, $coupon);
        $this->assertEquals( // veendu et võrdub
            12, // oodatav tulemus
            $output, // see mis tuleb reaalselt
            'When summing the total should equal 12' // teade tuleb vea korral
        );
    }
    // Kui tagasikutsumine viitab määratlemata meetodile või kui puuduvad mõned argumendid
    public function testTotalException() {
        $input = [0,2,5,8];
        $coupon = 1.20;
        $this->expectException('BadMethodCallException');
        $this->Receipt->total($input, $coupon);
    }


