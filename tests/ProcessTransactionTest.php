<?php

use jdavidbakr\ProfitStars\ProcessTransaction;
use jdavidbakr\ProfitStars\WSTransaction;

class ProcessTransactionTest extends TestCase
{
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ProcessTransaction;
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testTestConnection()
    {
        $this->assertTrue($this->object->TestConnection());
    }

    public function testTestCredentials()
    {
        $this->assertTrue($this->object->TestCredentials());
    }

    public function testAuthorizeTransactionFailure()
    {
        // First attempt with an empty transaction
        $trans = new WSTransaction;
        $this->assertFalse($this->object->AuthorizeTransaction($trans));
        $this->assertEquals($this->object->ResponseMessage, 'Server was unable to read request. ---> There is an error in XML document (14, 42). ---> The string \'\' is not a valid AllXsd value.');

        // Now try with a trans that will fail
        // I haven't been able to figure out how to get a trans to fail, so I'm hoping that what I have works? If not, I have it logging so we can identify how
        // we might need to handle this in the future should it come up.
        // $trans->RoutingNumber = 111000025;
        // $trans->AccountNumber = 5637492437;
        // $trans->TotalAmount = 9.95;
        // $trans->TransactionNumber = str_random(10);
        // $trans->NameOnAccount = str_random(10);
        // $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");
        // $this->assertFalse($this->object->AuthorizeTransaction($trans));
        // dd($this->object->ResponseMessage);
    }

    public function testAuthorizeTransactionSuccess()
    {
        $trans = new WSTransaction;
        $trans->RoutingNumber = 111000025;
        $trans->AccountNumber = 5637492437;
        $trans->TotalAmount = 9.95;
        $trans->TransactionNumber = str_random(10);
        $trans->NameOnAccount = str_random(10);
        $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");
        $this->assertTrue($this->object->AuthorizeTransaction($trans), $this->object->ResponseMessage);
    }

    public function testCaptureTransaction()
    {
        $trans = new WSTransaction;
        $trans->RoutingNumber = 111000025;
        $trans->AccountNumber = 5637492437;
        $trans->TotalAmount = 9.95;
        $trans->TransactionNumber = str_random(10);
        $trans->NameOnAccount = str_random(10);
        $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");
        $this->assertTrue($this->object->AuthorizeTransaction($trans), $this->object->ResponseMessage);

        // Capture the transaction.  ReferenceNumber will carry through from Authorize.
        $this->assertTrue($this->object->CaptureTransaction($trans->TotalAmount), $this->object->ResponseMessage);
    }

    public function testVoidTransaction()
    {
        $trans = new WSTransaction;
        $trans->RoutingNumber = 111000025;
        $trans->AccountNumber = 5637492437;
        $trans->TotalAmount = 9.95;
        $trans->TransactionNumber = str_random(10);
        $trans->NameOnAccount = str_random(10);
        $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");
        $this->assertTrue($this->object->AuthorizeTransaction($trans), $this->object->ResponseMessage);

        $this->assertTrue($this->object->VoidTransaction(), $this->object->ResponseMessage);
    }

    public function testRefundTransaction()
    {
        $trans = new WSTransaction;
        $trans->RoutingNumber = 111000025;
        $trans->AccountNumber = 5637492437;
        $trans->TotalAmount = 9.95;
        $trans->TransactionNumber = str_random(10);
        $trans->NameOnAccount = str_random(10);
        $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");
        $this->assertTrue($this->object->AuthorizeTransaction($trans), $this->object->ResponseMessage);
        $ReferenceNumber = $this->object->ReferenceNumber;

        // Capture the transaction.  ReferenceNumber will carry through from Authorize.
        $this->assertTrue($this->object->CaptureTransaction($trans->TotalAmount), $this->object->ResponseMessage);

        // Refund the transaction.  We have to pass the original reference number.
        $this->object->ReferenceNumber = $ReferenceNumber;
        // We can't refund the transaction yet because it's not cleared, so we should get the following exception when we try
        $this->assertFalse($this->object->RefundTransaction(), $this->object->ResponseMessage);
        $this->assertEquals($this->object->ResponseMessage, "Server was unable to process request. ---> An exception of type System.ArgumentException was thrown. The message was Transaction is in a state that cannot be refunded\nParameter name: originalReferenceNumber");
    }

}
