<?php 

namespace jdavidbakr\ProfitStars;

class WSSettlementBatch {
	public $entryType;
	public $batchDescription;
	public $reason;
	public $amount;
	/**
	 * @var jdavidbakr\ProfitStars\WSTransactionDetail
	 */
	public $transactionDetails;
}