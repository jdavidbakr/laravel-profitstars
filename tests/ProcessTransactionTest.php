<?php

namespace jdavidbakr\ProfitStars\Test;

use Illuminate\Support\Str;
use jdavidbakr\ProfitStars\ProcessTransaction;
use jdavidbakr\ProfitStars\WSTransaction;
use Mockery;
use Psr\Http\Message\ResponseInterface;

class ProcessTransactionTest extends BaseTestCase
{
    protected $object;

    public function setUp(): void
    {
        parent::setUp();
        $this->object = new ProcessTransaction;
    }

    public function testTestConnection()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <TestConnectionResponse xmlns="https://ssl.selectpayment.com/PV">
                            <TestConnectionResult>true</TestConnectionResult>
                        </TestConnectionResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $this->assertTrue($this->object->TestConnection());
    }

    public function testTestCredentials()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <TestCredentialsResponse xmlns="https://ssl.selectpayment.com/PV">
                            <TestCredentialsResult>
                                <returnValue>Success</returnValue>
                            </TestCredentialsResult>
                        </TestCredentialsResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $this->assertTrue($this->object->TestCredentials());
    }

    public function testAuthorizeTransactionFailure()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <AuthorizeTransactionResponse xmlns="https://ssl.selectpayment.com/PV">
                            <AuthorizeTransactionResult>
                                <Success>false</Success>
                                <ResponseMessage>Error message</ResponseMessage>
                            </AuthorizeTransactionResult>
                        </AuthorizeTransactionResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        // First attempt with an empty transaction
        $trans = new WSTransaction;
        $this->assertFalse($this->object->AuthorizeTransaction($trans));
        $this->assertEquals($this->object->ResponseMessage, 'Error message');
    }

    public function testAuthorizeTransactionSuccess()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <AuthorizeTransactionResponse xmlns="https://ssl.selectpayment.com/PV">
                            <AuthorizeTransactionResult>
                                <Success>true</Success>
                            </AuthorizeTransactionResult>
                        </AuthorizeTransactionResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $trans = new WSTransaction;
        $trans->RoutingNumber = 111000025;
        $trans->AccountNumber = 5637492437;
        $trans->TotalAmount = 9.95;
        $trans->TransactionNumber = Str::random(10);
        $trans->NameOnAccount = Str::random(10);
        $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");
        $this->assertTrue($this->object->AuthorizeTransaction($trans));
    }

    public function testCaptureTransaction()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <CaptureTransactionResponse xmlns="https://ssl.selectpayment.com/PV">
                            <CaptureTransactionResult>
                                <Success>true</Success>
                            </CaptureTransactionResult>
                        </CaptureTransactionResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $trans = new WSTransaction;
        $trans->RoutingNumber = 111000025;
        $trans->AccountNumber = 5637492437;
        $trans->TotalAmount = 9.95;
        $trans->TransactionNumber = Str::random(10);
        $trans->NameOnAccount = Str::random(10);
        $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");

        // Capture the transaction.  ReferenceNumber will carry through from Authorize.
        $this->assertTrue($this->object->CaptureTransaction($trans->TotalAmount));
    }

    public function testVoidTransaction()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <VoidTransactionResponse xmlns="https://ssl.selectpayment.com/PV">
                            <VoidTransactionResult>
                                <Success>true</Success>
                            </VoidTransactionResult>
                        </VoidTransactionResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $trans = new WSTransaction;
        $trans->RoutingNumber = 111000025;
        $trans->AccountNumber = 5637492437;
        $trans->TotalAmount = 9.95;
        $trans->TransactionNumber = Str::random(10);
        $trans->NameOnAccount = Str::random(10);
        $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");

        $this->assertTrue($this->object->VoidTransaction());
    }

    public function testRefundTransaction()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <RefundTransactionResponse xmlns="https://ssl.selectpayment.com/PV">
                            <RefundTransactionResult>
                                <Success>true</Success>
                            </RefundTransactionResult>
                        </RefundTransactionResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $trans = new WSTransaction;
        $trans->RoutingNumber = 111000025;
        $trans->AccountNumber = 5637492437;
        $trans->TotalAmount = 9.95;
        $trans->TransactionNumber = Str::random(10);
        $trans->NameOnAccount = Str::random(10);
        $trans->EffectiveDate = \Carbon\Carbon::now()->format("Y-m-d");
        $ReferenceNumber = $this->object->ReferenceNumber;
        // Refund the transaction.  We have to pass the original reference number.
        $this->object->ReferenceNumber = $ReferenceNumber;

        $this->assertTrue($this->object->RefundTransaction());
    }
}
