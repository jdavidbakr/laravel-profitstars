<?php

namespace jdavidbakr\ProfitStars\Test;

use Illuminate\Support\Str;
use jdavidbakr\ProfitStars\PaymentVault;
use jdavidbakr\ProfitStars\WSAccount;
use jdavidbakr\ProfitStars\WSCustomer;
use jdavidbakr\ProfitStars\WSRecurr;
use Mockery;
use Psr\Http\Message\ResponseInterface;

class PaymentVaultTest extends BaseTestCase
{
    protected $object;

    public function setUp(): void
    {
        parent::setUp();
        $this->object = new PaymentVault;
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

    public function testRecurring()
    {
        $this->guzzle->shouldReceive('post')
            ->times(1)
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <RegisterCustomerResponse xmlns="https://ssl.selectpayment.com/PV">
                            <RegisterCustomerResult>
                                <returnValue>Success</returnValue>
                            </RegisterCustomerResult>
                        </RegisterCustomerResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $this->guzzle->shouldReceive('post')
            ->times(1)
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <RegisterAccountResponse xmlns="https://ssl.selectpayment.com/PV">
                            <RegisterAccountResult>
                                <returnValue>Success</returnValue>
                            </RegisterAccountResult>
                        </RegisterAccountResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $this->guzzle->shouldReceive('post')
            ->times(1)
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <SetupRecurringPaymentResponse xmlns="https://ssl.selectpayment.com/PV">
                            <SetupRecurringPaymentResult>
                                <returnValue>Success</returnValue>
                            </SetupRecurringPaymentResult>
                        </SetupRecurringPaymentResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $faker = \Faker\Factory::create();
        $customer_number = Str::random(50);
        $account_reference_id = Str::random(50);

        // 1. Register a new customer
        $cust = new WSCustomer;
        $cust->IsCompany = false;
        $cust->CustomerNumber = $customer_number;
        $cust->LastName = $faker->lastName;

        $this->assertTrue($this->object->RegisterCustomer($cust));

        // 2. Register a new account
        $account = new WSAccount;
        $account->NameOnAccount = $faker->name;
        $account->AccountNumber = '9900000002';
        $account->RoutingNumber = '021000021';
        $account->AccountReferenceID = $account_reference_id;
        $account->CustomerNumber = $customer_number;

        $this->assertTrue($this->object->RegisterAccount($account));

        // 3. Set up a recurring payment
        $start_date = \Carbon\Carbon::now()->addMonth(1);
        $recur = new WSRecurr;
        $recur->CustomerNumber = $customer_number;
        $recur->AccountReferenceID = $account_reference_id;
        $recur->Amount = 100;
        $recur->Frequency = 'Once_a_Month';
        $recur->PaymentDay = $start_date->day;
        $recur->StartDate = $start_date->format("Y-m-d");
        $recur->NextPaymentDate = $start_date->format("Y-m-d");
        $recur->NumPayments = 5;
        $recur->PaymentsToDate = 0;
        $recur->RecurringReferenceID = Str::random(50);

        $this->assertTrue($this->object->SetupRecurringPayment($recur));
    }
}
