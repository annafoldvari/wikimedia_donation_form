<?php

use PHPUnit\Framework\TestCase;
use PHPHtmlParser\Dom;

class Tests extends TestCase
{
    protected function setUp(): void {
      $this->details['first-name'] = "Sarah";
      $this->details['last-name'] = "Evans";
      $this->details['street-address'] = "5 Bird Street";
      $this->details['city'] = "London";
      $this->details['state'] = "";
      $this->details['country'] = "Hungary";
      $this->details['postal-code'] = "1022";
      $this->details['phone-number'] = "0123456789";
      $this->details['email'] = "sarah@email.com";
      $this->details['preferred-contact'] = "email";
      $this->details['comment'] = "Hello";
      $this->details['frequency'] = "monthly";
      $this->details['preferred-payment'] = "eur";

      $this->details2['first-name'] = "Gregory";
      $this->details2['last-name'] = "Smith";
      $this->details2['street-address'] = "2 Canary Street";
      $this->details2['city'] = "Manchester";
      $this->details2['state'] = "Yorkshire";
      $this->details2['country'] = "UK";
      $this->details2['postal-code'] = "GU22 3NL";
      $this->details2['phone-number'] = "1234567";
      $this->details2['email'] = "gregory@email.com";
      $this->details2['preferred-contact'] = "phone";
      $this->details2['comment'] = "Hello there";
      $this->details2['frequency'] = "onetime";
      $this->details2['preferred-payment'] = "eur";

      $this->yearly_donation['dollars'] = 360;
      $this->yearly_donation['eur'] = 240;
    }

    public function testBuildDetailsIncludesFirstName()
    {
      $output = buildDetails($this->details, $this->yearly_donation);

      $dom = new Dom;
      $dom->loadStr($output);
      $first_name = $dom->find('.first_name')[0];  
      
      $this->assertEquals($first_name->text, 'Sarah');
    }

    public function testBuildDetailsIncludesMonthlyDonationEur()
    {
      $output = buildDetails($this->details, $this->yearly_donation);

      $dom = new Dom;
      $dom->loadStr($output);
      $donation_eur = $dom->find('.donation_eur')[0]; 
      
      $this->assertEquals($donation_eur->text, '240 EUR');
    }

    public function testBuildDetailsIncludesMonthlyDonationUsd()
    {
      $output = buildDetails($this->details, $this->yearly_donation);

      $dom = new Dom;
      $dom->loadStr($output);
      $donation_usd = $dom->find('.donation_usd')[0];  
      
      $this->assertEquals($donation_usd->text, '360 USD');
    } 

    public function testBuildDetailsIncludesOneTimeDonation()
    {
      $output = buildDetails($this->details2, $this->yearly_donation);

      $dom = new Dom;
      $dom->loadStr($output);
      $donation_usd = $dom->find('.donation')[0];  
      
      $this->assertEquals($donation_usd->text, 'You are donating a one-time amount of 360 USD or 240 Euro');
    }

    public function testBuildFormIncludesEmail()
    {
      $output = buildForm($this->details);

      $dom = new Dom;
      $dom->loadStr($output);
      $email = $dom->find('#email')[0];  
      
      $this->assertEquals($email->value, 'sarah@email.com');
    }
}