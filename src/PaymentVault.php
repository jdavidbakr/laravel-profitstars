<?php

namespace jdavidbakr\ProfitStars;

use jdavidbakr\ProfitStars\Exceptions\RegisterAccountException;
use jdavidbakr\ProfitStars\Exceptions\RegisterCustomerException;
use jdavidbakr\ProfitStars\Exceptions\SetupRecurringPaymentException;

class PaymentVault extends RequestBase
{
    protected $endpoint = 'https://ws.eps.profitstars.com/PV/PaymentVault.asmx';
    public $ReferenceNumber;
    public $ResponseMessage;

    /**
     * Tests the connection to the web service
     */
    public function TestConnection()
    {
        $view = view('profitstars::payment-vault.test-connection');
        $xml = $this->Call($view);
        if (!$xml) {
            abort(500, $this->faultstring);
        }
        return (bool)$xml->TestConnectionResult[0];
    }

    public function TestCredentials()
    {
        $view = view('profitstars::payment-vault.test-credentials');
        $xml = $this->Call($view);
        if (!$xml) {
            abort(500, $this->faultstring);
        }
        return $xml->TestCredentialsResult[0]->returnValue[0] == 'Success';
    }

    public function RegisterCustomer(WSCustomer $customer)
    {
        $view = view('profitstars::payment-vault.register-customer', [
                'customer'=>$customer,
            ]);
        $xml = $this->Call($view);
        if (!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return false;
        }
        if (!$xml->RegisterCustomerResult || (string)$xml->RegisterCustomerResult->returnValue[0] != 'Success') {
            if ($xml->RegisterCustomerResult && (string)$xml->RegisterCustomerResult->ResponseMessage[0]) {
                // Not sure if this is working, so I'm going to throw the XML into the logs in case
                // I need to come back and see what it looks like.
                logger($xml->asXML());
                $this->ResponseMessage = (string)$xml->RegisterCustomerResult->ResponseMessage[0];
            } else {
                // Had an error with the call that was not captured above, so let's log it and throw a 500 error for future development
                logger:info($xml->asXML());
                throw new RegisterCustomerException($xml->asXML());
            }
            return false;
        }
        return true;
    }

    public function RegisterAccount(WSAccount $account)
    {
        $view = view('profitstars::payment-vault.register-account', [
                'account'=>$account,
            ]);
        // dd($view->render());
        $xml = $this->Call($view);
        if (!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return false;
        }
        if (!$xml->RegisterAccountResult || (string)$xml->RegisterAccountResult->returnValue[0] != 'Success') {
            if ($xml->RegisterAccountResult && (string)$xml->RegisterAccountResult->ResponseMessage[0]) {
                // Not sure if this is working, so I'm going to throw the XML into the logs in case
                // I need to come back and see what it looks like.
                logger($xml->asXML());
                $this->ResponseMessage = (string)$xml->RegisterAccountResult->ResponseMessage[0];
            } else {
                // Had an error with the call that was not captured above, so let's log it and throw a 500 error for future development
                logger:info($xml->asXML());
                throw new RegisterAccountException($xml->asXML());
            }
            return false;
        }
        return true;
    }

    public function SetupRecurringPayment(WSRecurr $recur)
    {
        $view = view('profitstars::payment-vault.setup-recurring-payment', [
                'recur'=>$recur,
            ]);
        // dd($view->render());
        $xml = $this->Call($view);
        if (!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return false;
        }
        if (!$xml->SetupRecurringPaymentResult || (string)$xml->SetupRecurringPaymentResult->returnValue[0] != 'Success') {
            if ($xml->SetupRecurringPaymentResult && (string)$xml->SetupRecurringPaymentResult->message[0]) {
                // Not sure if this is working, so I'm going to throw the XML into the logs in case
                // I need to come back and see what it looks like.
                logger($xml->asXML());
                $this->ResponseMessage = (string)$xml->SetupRecurringPaymentResult->message[0];
            } else {
                // Had an error with the call that was not captured above, so let's log it and throw a 500 error for future development
                logger:info($xml->asXML());
                throw new SetupRecurringPaymentException($xml->asXML());
            }
            return false;
        }
        return true;
    }
}
