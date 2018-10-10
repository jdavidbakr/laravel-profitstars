<?php

use jdavidbakr\ProfitStars\TransactionReporting;
use Carbon\Carbon;

class TransactionReportingTest extends TestCase
{
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new TransactionReporting;
    }

    public function testCreditAndDebitReports()
    {
        $start_date = Carbon::now()->subDays(90);
        $end_date = Carbon::now();

        $response = $this->object->CreditAndDebitReports($start_date, $end_date);
        $this->assertNotNull($response);

        if (!$response->count()) {
            // We can't preload the data, so just mark the test incomplete if we have nothing
            $this->markTestIncomplete();
            return;
        }

        $response->each(function ($item) {
            $this->assertEquals('jdavidbakr\ProfitStars\CreditAndDebitReportsResponse', get_class($item));
        });
    }

    public function testCreditsAndDebitsTransactionDetailReport()
    {
        $start_date = Carbon::now()->subDays(90);
        $end_date = Carbon::now();

        $batches = $this->object->CreditAndDebitReports($start_date, $end_date);
        $this->assertNotNull($batches);

        if (!$batches->count()) {
            // We can't preload the data, so just mark the test incomplete if we have nothing
            $this->markTestIncomplete();
            return;
        }

        $batch = $batches->first();

        $transactions = $this->object->CreditsAndDebitsTransactionDetailReport($batch->batchID);
        $this->assertGreaterThan(0, $transactions->count());
    }
}
