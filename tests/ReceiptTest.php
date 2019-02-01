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
    // uus funktsioon "testTotalAndCoupon", aga koos coupon-i väärtusega. Testimeetod, mis kontrollib summa ning summale lisatud kupongi arvutamise korrektset toimimist
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

// kogu summale maksu õigesti lisamise kontroll-funktsioon koos Mock objektiga

    public function testPostTaxTotal() {
        $items = [1,2,5,8];
        $tax = 0.20;
        $coupon = null;
        $Receipt = $this->getMockBuilder('TDD\Receipt')
            // Receipt klassi alusel luuakse Mock objekt
        ->setMethods(['tax', 'total']) // need meetodid lisatakse Mock objektile
        ->getMock(); // Mock object omab Receipt objekti omadusi
        $Receipt->expects($this->once()) // meetod total kutsutakse välja üks kord
        ->method('total') // Mock objekti meetod total
        ->with($items, $coupon) // need on argumentideks
        ->will($this->returnValue(10.00)); // ette antud suurus total=10
        $Receipt->expects($this->once()) // meetod tax kutsutakse välja üks kord
        ->method('tax') // Mock objekti meetod tax
        ->with(10.00, $tax) // koos väärtuse ja argumendiga
        ->will($this->returnValue(1.00)); // ette antud suurus tax=1
        $result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null); // mock objekti meetod koos argumentidega
        //veendutakse, et kutsuti välja Mock-objekti meetod total(), mis tagastas väärtuse 10.00 ning sama Mock-objekti
        // meetod tax(), mis tagastas väärtuse 1.00. Veendutakse, et mõlemad kutsututi välja ainult üks kord - expects($this->once())
        // NB! Kui liita aga kokku 115. real olevad massiiviliikmed 1,2,5,8 ning summast (16) lahutada maha kupongi väärtus (16-16*0.2),
        // siis saame tulemuseks 16-3.2=12.8. Seega, kui oleks tegu reaalse Receipt-klassi objektiga, siis real 124 olev assertEquals()
        // tagastaks "false" ehk testi tulemuseks oleks veateada (kuna 11.00 ei võrdu 12.8)
        // Kuna antud testis on kasutusel Mock-objekt, siis testitakse ainult tingimusi, mis on kirjeldatud real 117-118 ning
        // seetõttu assertEquals(11.00, $result) tagastab "true"
        $this->assertEquals(11.00, $result); // selline, ehk 11, peab olema Mock objekti tulemus
    }

