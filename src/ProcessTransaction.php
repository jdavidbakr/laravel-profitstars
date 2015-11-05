<?php

namespace jdavidbakr\ProfitStars;

class ProcessTransaction extends RequestBase {

    protected $endpoint = 'https://ws.eps.profitstars.com/PV/TransactionProcessing.asmx';
    public $ReferenceNumber;
    public $ResponseMessage;

    /**
     * Tests the connection to the web service
     */
    public function TestConnection()
    {
        $view = view('profitstars::process-transaction.test-connection');
        $xml = $this->Call($view);
        return (bool)$xml->TestConnectionResult[0];
    }

    public function TestCredentials()
    {
        $view = view('profitstars::process-transaction.test-credentials');
        $xml = $this->Call($view);
        return $xml->TestCredentialsResult[0]->returnValue[0] == 'Success';
    }

    public function AuthorizeTransaction(WSTransaction $trans)
    {
        $view = view('profitstars::process-transaction.authorize-transaction',[
                'trans'=>$trans,
            ]);
        $xml = $this->Call($view);
        if(!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return false;
        }
        if(!$xml->AuthorizeTransactionResult[0] || (string)$xml->AuthorizeTransactionResult[0]->Success[0] != 'true') {
            if($xml->AuthorizeTransactionResult[0] && (string)$xml->AuthorizeTransactionResult[0]->ResponseMessage[0]) {
                // Not sure if this is working, so I'm going to throw the XML into the logs in case
                // I need to come back and see what it looks like.
                logger($xml->asXML());
                $this->ResponseMessage = (string)$xml->AuthorizeTransactionResult[0]->ResponseMessage[0];
            } else {
                // Had an error with the call that was not captured above, so let's log it and throw a 500 error for future development
                logger:info($xml->asXML());
                abort(500, "AuthorizeTransaction error occurred");
            }
            return false;
        }
        $this->ReferenceNumber = (string)$xml->AuthorizeTransactionResult[0]->ReferenceNumber[0];
        return true;
    }

    /**
     * If not using AuthorizeTransaction, then set ReferenceNumber before calling this
     * @param [type] $amount [description]
     */
    public function CaptureTransaction($amount)
    {
        $view = view('profitstars::process-transaction.capture-transaction',[
                'captureAmount'=>$amount,
                'originalReferenceNumber'=>$this->ReferenceNumber,
            ]);
        $xml = $this->Call($view);
        if(!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return false;
        }
        if(!$xml->CaptureTransactionResult[0] || (string)$xml->CaptureTransactionResult[0]->Success[0] != 'true') {
            if($xml->CaptureTransactionResult[0] && (string)$xml->CaptureTransactionResult[0]->ResponseMessage[0]) {
                // Not sure if this is working, so I'm going to throw the XML into the logs in case
                // I need to come back and see what it looks like.
                logger($xml->asXML());
                $this->ResponseMessage = (string)$xml->CaptureTransactionResult[0]->ResponseMessage[0];
            } else {
                // Had an error with the call that was not captured above, so let's log it and throw a 500 error for future development
                logger:info($xml->asXML());
                abort(500, "CaptureTransaction error occurred");
            }
            return false;
        }
        // This reference number cannot be used to void/refund in the future
        $this->ReferenceNumber = (string)$xml->CaptureTransactionResult[0]->ReferenceNumber[0];
        return true;
    }

    public function VoidTransaction()
    {
        $view = view('profitstars::process-transaction.void-transaction',[
                'originalReferenceNumber'=>$this->ReferenceNumber,
            ]);
        $xml = $this->Call($view);
        if(!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return false;
        }
        if(!$xml->VoidTransactionResult[0] || (string)$xml->VoidTransactionResult[0]->Success[0] != 'true') {
            if($xml->VoidTransactionResult[0] && (string)$xml->VoidTransactionResult[0]->ResponseMessage[0]) {
                // Not sure if this is working, so I'm going to throw the XML into the logs in case
                // I need to come back and see what it looks like.
                logger($xml->asXML());
                $this->ResponseMessage = (string)$xml->VoidTransactionResult[0]->ResponseMessage[0];
            } else {
                // Had an error with the call that was not captured above, so let's log it and throw a 500 error for future development
                logger:info($xml->asXML());
                abort(500, "CaptureTransaction error occurred");
            }
            return false;
        }
        $this->ReferenceNumber = (string)$xml->VoidTransactionResult[0]->ReferenceNumber[0];
        return true;
    }

    /**
     * Unlike Authorize.net, we can only refund the entire amount of the ACH
     */
    public function RefundTransaction()
    {
        $view = view('profitstars::process-transaction.refund-transaction',[
                'originalReferenceNumber'=>$this->ReferenceNumber,
            ]);
        // dd($view->render());
        $xml = $this->Call($view);
        if(!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return false;
        }
        if(!$xml->RefundTransactionResult[0] || (string)$xml->RefundTransactionResult[0]->Success[0] != 'true') {
            if($xml->RefundTransactionResult[0] && (string)$xml->RefundTransactionResult[0]->ResponseMessage[0]) {
                // Not sure if this is working, so I'm going to throw the XML into the logs in case
                // I need to come back and see what it looks like.
                logger($xml->asXML());
                $this->ResponseMessage = (string)$xml->RefundTransactionResult[0]->ResponseMessage[0];
            } else {
                // Had an error with the call that was not captured above, so let's log it and throw a 500 error for future development
                logger:info($xml->asXML());
                abort(500, "CaptureTransaction error occurred");
            }
            return false;
        }
        // Response message tells when the refund will take place.
        $this->ResponseMessage = (string)$xml->RefundTransactionResult[0]->ResponseMessage[0];
        $this->ReferenceNumber = (string)$xml->RefundTransactionResult[0]->ReferenceNumber[0];
        return true;
    }

}
