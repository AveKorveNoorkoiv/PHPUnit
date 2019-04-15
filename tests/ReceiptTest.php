<?php
namespace TDD\Test;
require 'vendor\autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;


    //Luuakse ReceiptTest klass, sellele laienevad TestCase klassi väärtused
class ReceiptTest extends TestCase {

    // laiendab TestCase klassi, pannakse tööle enne testmeetodite käivitamist, seal tehakse testimiseks vajalikud ettevalmistused
    public function setUp() {
    // luuakse uus objekt nimega Receipt
        $this->Receipt = new Receipt();
    }
    //Dummy object
    public function tearDown() {
    //objekt $Receipt kustutatakse mälust
        unset($this->Receipt);
    }
    public function testTotal($items, $expected) {
     // muutuja on väärtuseta
        $coupon = null;
      // kutsutakse välja total meetod ja annab ette items-i ja coupon-i
        $output = $this->Receipt->total($items, $coupon);
      // veendu et võrdub
        $this->assertEquals(
            $expected, //
            $output,
      // see teade tuleb vea korral
            'When summing the total should equal {$expected}'
        );
    }

    // andme edastus funktsioon koos ette antud väärtustega
public function provideTotal() {
    return [
     // kokku 16 jne
        'ints totaling 16' => [[1,2,5,8], 16],
        [[-1,2,5,8], 14],
        [[1,2,8], 11],
    ];
}

    // andme edastus funktsioon koos etteantud väärtustega
    public function provideTotal() {
        return [
            'ints totaling 16' => [[1,2,5,8], 16],
            [[-1,2,5,8], 14],
            [[1,2,8], 11],
        ];
    }
    // uus funktsioon "testTotalAndCoupon", aga koos coupon-i väärtusega.
    //Testimeetod, mis kontrollib summa ning summale lisatud kupongi arvutamise korrektset toimimist
    public function testTotalAndCoupon() {
        $input = [0,2,5,8];
     // nüüd on väärtus olemas
        $coupon = 0.20;
        $output = $this->Receipt->total($input, $coupon);
        $this->assertEquals(
      // oodatav tulemus
            12,
     // see mis tuleb reaalselt
            $output,
     // teade tuleb vea korral
            'When summing the total should equal 12'
        );
    }
    // Kui tagasikutsumine viitab määratlemata meetodile
    //või kui puuduvad mõned argumendid
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
     // need meetodid lisatakse Mock objektile
        ->setMethods(['tax', 'total'])
    // Mock objectil on Receipt objekti omadused
        ->getMock();
    // meetod total kutsutakse välja üks kord
        $Receipt->expects($this->once())
     // Mock objekti meetod total
        ->method('total')
     // argumentidid
        ->with($items, $coupon)
      // siin on ette antud suurus total=10
        ->will($this->returnValue(10.00));
      // meetod tax kutsutakse välja ainult üks kord
        $Receipt->expects($this->once())
     // see on Mock objekti meetod tax
        ->method('tax')
     // koos väärtuse ja argumendiga (kui enne oli ainult argumendid)
        ->with(10.00, $tax)
    // ette antud suurus tax=1
        ->will($this->returnValue(1.00));
    // mock objekti meetod koos argumentidega
        $result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
    //  11 peab olema Mock objekti tulemus  antud juhul
        $this->assertEquals(11.00, $result);
    }

    //testitakse summale makusosa lisamist
    public function testTax() {
     // sisendväärtus
        $inputAmount = 10.00;
     // kasu sisend
        $taxInput = 0.10;

        $output = $this->Receipt->tax($inputAmount, $taxInput);
      // veendu et võrdub
        $this->assertEquals(
      // oodatav tulemus
            1.00,
      // see mis tuleb reaalselt
            $output,
            // see teade tuleb vea korral
            'The tax calculation should equal 1.00'
        );
      }
    }