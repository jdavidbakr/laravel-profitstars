<?php

namespace jdavidbakr\ProfitStars;

use Carbon\Carbon;

class TransactionReporting extends RequestBase {

    protected $endpoint = 'https://ws.eps.profitstars.com/PV/TransactionReporting.asmx';

    /**
     * Retrieves the credit and debit reports data
     * @param Carbon $start_date 
     * @param Carbon $end_date   
     * @return Collection of jdavidbakr\ProfitStars\CreditAndDebitReportsResult
     */
    public function CreditAndDebitReports(Carbon $start_date, Carbon $end_date)
    {
        $view = view('profitstars::transaction-reporting.credit-and-debit-reports',[
                'beginDate'=>$start_date,
                'endDate'=>$end_date,
            ]);
        $xml = $this->call($view);
        if(!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return null;
        }
        $batches = collect();
        if($xml->CreditandDebitReportsResult[0]->children('diffgr',true)[0]->children()[0]) {
            foreach($xml->CreditandDebitReportsResult[0]->children('diffgr',true)[0]->children()[0]->Table as $table) {
                $response = new CreditAndDebitReportsResponse;
                $response->batchStatus = (string)$table->BatchStatus;
                $response->effectiveDate = Carbon::parse($table->EffectiveDate);
                $response->batchID = (string)$table->BatchID;
                $response->description = (string)$table->Description;
                $response->amount = (string)$table->Amount;
                $batches->push($response);
            }
        }
        return $batches;
    }

    public function CreditsAndDebitsTransactionDetailReport($batchId)
    {
        $view = view('profitstars::transaction-reporting.credit-and-debit-transaction-detail-reports',[
                'batchId'=>$batchId,
            ]);
        $xml = $this->call($view);
        if(!$xml) {
            $this->ResponseMessage = $this->faultstring;
            return null;
        }
        $transactions = collect();
        foreach($xml->CreditsandDebitsTransactionDetailReportResult[0]->WSSettlementBatch as $item) {
            $settlement_batch = new WSSettlementBatch;
            $transaction_detail = new WSTransactionDetail;

            $transaction_detail->entityId = (string)$item->transactionDetails->EntityId;
            $transaction_detail->locationId = (string)$item->transactionDetails->LocationId;
            $transaction_detail->customerNumber = (string)$item->transactionDetails->CustomerNumber;
            $transaction_detail->paymentOrigin = (string)$item->transactionDetails->PaymentOrigin;
            $transaction_detail->accountType = (string)$item->transactionDetails->AccountType;
            $transaction_detail->operationType = (string)$item->transactionDetails->OperationType;
            $transaction_detail->transactionStatus = (string)$item->transactionDetails->TransactionStatus;
            $transaction_detail->settlementStatus = (string)$item->transactionDetails->SettlementStatus;
            $transaction_detail->effectiveDate = Carbon::parse($item->transactionDetails->EffectiveDate);
            $transaction_detail->transactionDate = Carbon::parse($item->transactionDetails->TransactionDate);
            $transaction_detail->description = (string)$item->transactionDetails->Description;
            $transaction_detail->sourceApplication = (string)$item->transactionDetails->SourceApplication;
            $transaction_detail->originatingAs = (string)$item->transactionDetails->OriginatingAs;
            $transaction_detail->authResponse = (string)$item->transactionDetails->AuthResponse;
            $transaction_detail->totalAmount = (string)$item->transactionDetails->TotalAmount;
            $transaction_detail->referenceNumber = (string)$item->transactionDetails->ReferenceNumber;
            $transaction_detail->transactionNumber = (string)$item->transactionDetails->TransactionNumber;
            $transaction_detail->field1 = (string)$item->transaction_details->Field1;
            $transaction_detail->field2 = (string)$item->transaction_details->Field2;
            $transaction_detail->field3 = (string)$item->transaction_details->Field3;
            $transaction_detail->displayAccountNumber = (string)$item->transaction_details->DisplayAccountNumber;
            $transaction_detail->emailAddress = (string)$item->transaction_details->EmailAddress;
            $transaction_detail->notificationMethod = (string)$item->transaction_details->NotificationMethod;
            $transaction_detail->faceFeeType = (string)$item->transaction_details->FaceFeeType;

            $settlement_batch->entryType = (string)$item->EntryType;
            $settlement_batch->batchDescription = (string)$item->BatchDescription;
            $settlement_batch->reason = (string)$item->Reason;
            $settlement_batch->amount = (string)$item->Amount;
            $settlement_batch->transactionDetails = $transaction_detail;

            $transactions->push($settlement_batch);
        }
        return $transactions;
    }
}
