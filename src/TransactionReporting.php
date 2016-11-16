<?php

namespace jdavidbakr\ProfitStars;

use Carbon\Carbon;
use jdavidbakr\ProfitStars\CreditAndDebitReportsResponse;

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
    	foreach($xml->CreditandDebitReportsResult[0]->children('diffgr',true)[0]->children()[0]->Table as $table) {
    		$response = new CreditAndDebitReportsResponse;
    		$response->batchStatus = (string)$table->BatchStatus;
    		$response->effectiveDate = Carbon::parse($table->EffectiveDate);
    		$response->batchID = (string)$table->BatchID;
    		$response->description = (string)$table->Description;
    		$response->amount = (string)$table->Amount;
    		$batches->push($response);
    	}
    	return $batches;
    }
}
